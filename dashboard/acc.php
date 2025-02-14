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
    <title>Admin Accounts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .bg-pastel-blue { background-color: #A7C7E7; }
        .bg-pastel-green { background-color: #A9E2A9; }
        .bg-pastel-yellow { background-color: #F8E28C; }
        .bg-pastel-white { background-color: #FFFFFF; }
        .text-dark-gray { color: #333333; }
        .table-container { overflow-x: auto; min-height: 400px; }
        table { border-radius: 10px; overflow: hidden; }
        th { background-color: #F8E28C; padding: 12px; text-align: left; font-weight: bold; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: #f1f5f9; transition: 0.3s; }
    </style>
</head>
<body class="bg-pastel-blue text-gray-800 min-h-screen flex flex-col">

<nav class="bg-pastel-green p-4 shadow-lg">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <span class="text-xl font-semibold text-dark-gray">Event Manager</span>
        <div class="flex gap-4">
            <a href="./home.php" class="text-gray-700 hover:text-orange-500">Event's List</a>
            <a href="#" class="text-gray-700 hover:text-orange-500">Admin Accounts</a>
            <a href="#" id="logoutBtn" class="text-gray-700 hover:text-red-600">Logout</a>
        </div>
    </div>
</nav>

<main class="flex-grow p-6 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-center mb-6 text-dark-gray">List of Admins</h1>
    <div class="flex justify-between mb-4">
        <a class="text-lg text-orange-500 hover:underline" href="./post-acc.php">Add Account +</a>
    </div>

    <div>
        <table class="w-full border-collapse overflow-hidden rounded-lg">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include("../service/connection.php");
                $query = $conn->query("SELECT * FROM admin WHERE id != " . $_SESSION['id']);
                while ($row = $query->fetch_assoc()): ?>
                    <tr class="text-center hover:bg-gray-100 transition">
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?= $row['updated_at'] ?></td>
                        <td class="flex justify-center gap-3">
                            <a href='edit-acc.php?id=<?= $row["id"] ?>' class='text-blue-500 hover:text-blue-700'>
                                <i data-lucide="pencil" class="w-5 h-5"></i>
                            </a>
                            <a href='#' onclick="confirmDelete(<?= $row['id'] ?>)" class='text-red-500 hover:text-red-700'>
                                <i data-lucide="trash" class="w-5 h-5"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<footer class="bg-pastel-green text-center p-4 mt-auto w-full">
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../service/auth.php?id=${id}&value=del_acc`;
            }
        });
    }
</script>

</body>
</html>