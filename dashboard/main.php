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
    <title>Guest Book Admin Dashboard</title>
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
            <a href="home.php" class="text-gray-700 hover:text-pastel-orange">Event's List</a>
            <a href="./acc.php" class="text-gray-700 hover:text-pastel-orange">Admin Accounts</a>
            <a href="#" id="logoutBtn" class="text-gray-700 hover:text-red-600">Logout</a>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6 flex-grow">
    <h1 class="text-3xl font-bold text-center text-dark-gray mb-6">Guest Book Admin</h1>
    <div class="flex justify-between mb-4">
    </div>

    <?php
    include "../service/connection.php";

    // Get event ID from URL
    if (!isset($_SESSION['id'])) {
        $_SESSION['id'] = intval($_GET['id']);
    } else if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $_SESSION['id'] = intval($_GET['id']);
    }

    $id = $_SESSION['id'];

    // Handle pagination
    $records_per_page = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;

    // Handle search term
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Handle sorting
    $sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'id'; // Default to 'id'
    $sort_order = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'ASC' : 'DESC'; // Default to descending order

    // Modify the query to include search and sorting
    $sql =  "SELECT r.id, t.nama AS nama, r.date, r.time, e.name AS events
             FROM reports r
             JOIN tamu t ON r.fid_tamu = t.id
             JOIN events e ON r.events_fid = e.id
             WHERE r.events_fid = $id
             AND (t.nama LIKE '%$search%' OR e.name LIKE '%$search%')
             ORDER BY $sort_column $sort_order
             LIMIT $offset, $records_per_page";

    $query = $conn->query($sql);

    // Count total records
    $total_records_query = "SELECT COUNT(*) AS total
                            FROM reports r
                            JOIN events e ON r.events_fid = e.id
                            WHERE e.name LIKE '%$search%'";
    $total_records_result = $conn->query($total_records_query);
    $total_records = $total_records_result->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $records_per_page);
    ?>

    <table>
        <thead>
            <tr>
                <th onclick="sortTable('id')">ID</th>
                <th onclick="sortTable('nama')">Name</th>
                <th onclick="sortTable('date')">Date</th>
                <th onclick="sortTable('time')">Time</th>
                <th onclick="sortTable('events')">Event</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['time'] ?></td>
                    <td><?= $row['events'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination flex justify-center mt-6">
        <?php if ($page > 1): ?>
            <a href="?id=<?=$id?>&page=<?= $page - 1 ?>&search=<?= $search ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>" class="btn btn-sm btn-pastel-orange">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?id=<?=$id?>&page=<?= $i ?>&search=<?= $search ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>" class="btn btn-sm <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?id=<?=$id?>&page=<?= $page + 1 ?>&search=<?= $search ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>" class="btn btn-sm btn-pastel-orange">Next</a>
        <?php endif; ?>
    </div>

    <div class="flex justify-center mt-8 mb-10 space-x-4">
        <button onclick="location.href = 'pdf.php'" class="btn btn-pastel-orange">Generate Report</button>
    </div>
</main>

<footer class="bg-pastel-green text-center p-4">
    <p class="text-sm text-black">&copy; 2025 Indah Callista Excella. All rights reserved.</p>
</footer>

<script>
    lucide.createIcons();

    // Sorting function
    function sortTable(column) {
        const currentUrl = new URL(window.location.href);
        const currentSort = currentUrl.searchParams.get('sort');
        const currentOrder = currentUrl.searchParams.get('order') === 'asc' ? 'desc' : 'asc';

        currentUrl.searchParams.set('sort', column);
        currentUrl.searchParams.set('order', currentOrder);

        window.location.href = currentUrl.toString();
    }
    
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