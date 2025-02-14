<?php 
session_start();
if (isset($_SESSION['username']) == false) {
    header("location: index.php");
exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="font-ubuntu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .bg-pastel-blue { background-color: #A7C7E7; }
        .bg-pastel-green { background-color: #A9E2A9; }
        .bg-pastel-yellow { background-color: #F8E28C; }
        .text-pastel-orange { color: #FF9E3D; }
        .text-dark-gray { color: #333333; }

        /* Hover Effects */
        .btn:hover { background-color: #FF9E3D; transform: scale(1.05); transition: all 0.3s ease; }
        #searchInput:focus { border-color: #FF9E3D; outline: none; transition: border-color 0.3s ease; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #F8E28C; }
        tr:hover { background-color: rgba(167, 199, 231, 0.3); transition: background-color 0.3s ease; }

        /* Pagination */
        .pagination a { padding: 8px 12px; margin: 0 4px; border-radius: 5px; }
        .pagination a.active { background-color: #FF9E3D; color: white; }
        .pagination a:hover { background-color: #F8E28C; }
    </style>
</head>
<body class="bg-pastel-blue text-gray-800 flex flex-col min-h-screen">

<nav class="bg-pastel-green p-4 shadow-lg">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <span class="text-xl font-semibold text-dark-gray">Event Manager</span>
        <div class="flex gap-6">
            <a href="./home.php" class="text-gray-700 hover:text-pastel-orange">Event's List</a>
            <a href="./acc.php" class="text-gray-700 hover:text-pastel-orange">Admin Accounts</a>
            <a href="" id="logoutBtn" class="text-gray-700 hover:text-red-600">Logout</a>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6 flex-grow">
    <h1 class="text-3xl font-bold text-center text-dark-gray mb-6">Events List</h1>
    <div class="flex justify-between mb-4">
        <a class="text-lg text-pastel-orange hover:underline" href="./create_event.php">Add New Event +</a>
        
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({ title: 'Success', text: '<?php echo $_SESSION['success']; ?>', icon: 'success', timer: 1500, showConfirmButton: false });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({ title: 'Error', text: '<?php echo $_SESSION['error']; ?>', icon: 'error', timer: 1500, showConfirmButton: false });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php
    include("../service/connection.php");
    $limit = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM events");
    $total_row = $total_result->fetch_assoc();
    $total_pages = ceil($total_row['total'] / $limit);
    $query = $conn->query("SELECT * FROM events LIMIT $start, $limit");
    ?>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Instansi</th>
                <th>Start</th>
                <th>Over</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include("../service/connection.php");

        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

        $queryStr = "SELECT * FROM events";
        if (!empty($search)) {
          $queryStr .= " WHERE name LIKE '%$search%'";
        }

        $query = $conn->query($queryStr);

        while ($row = $query->fetch_assoc()) {
        ?>
          <tr style="background: <?= $row['waktu_berakhir'] >= date("Y-m-d") == 1 ? ($row['waktu_mulai'] <= date("Y-m-d") ? 'rgba(0, 255, 0, 0.5)' : 'rgba(193, 195, 44, 0.5)') : 'rgba(58, 58, 58, 0.5)' ?>">
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['instansi'] ?></td>
            <td><?= $row['waktu_mulai'] ?></td>
            <td><?= $row['waktu_berakhir'] ?></td>
            <td>
              <a class='btn btn-primary' href='main.php?id=<?= $row["id"] ?>' >See Details</a>
              <a class='btn btn-danger' href='../service/auth.php?id=<?= $row["id"] ?>&value=del_e'
                onclick="return confirmDelete(event, <?= $row['id'] ?>)">Delete</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination flex justify-center mt-6">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-sm btn-pastel-orange">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="btn btn-sm <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-sm btn-pastel-orange">Next</a>
        <?php endif; ?>
    </div>

</main>

<footer class="bg-pastel-green text-center p-4">
    <p class="text-sm text-black">&copy; 2025 Indah Callista Excella. All rights reserved.</p>
</footer>

<script>
    lucide.createIcons();
    document.getElementById("logoutBtn").addEventListener("click", function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure you want to logout?',
        text: "You will be redirected to the login page.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, logout!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Logging out...',
                text: 'Please wait...',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "./../logout.php";
            });
        }
    });
});

</script>

</body>
</html>
