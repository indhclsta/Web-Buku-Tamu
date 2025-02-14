<?php
include "../service/connection.php";

session_start();
if (isset($_SESSION['username']) == false) {
    header("location: index.php");
exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id'])) {
        header('location: ./acc.php');
        exit;
    }

    $id = $_GET['id'];
    $sql = "SELECT username,email,phone,password FROM admin WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header('location: ./acc.php');
        exit;
    }

    $name = $row['username'];
    $email = $row['email'];
    $phone = $row['phone'];
    $password = $row['password'];
} else {
    header('location: ./acc.php');
    $_SESSION['error'] = 'Data tidak ditemukan';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="font-ubuntu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    
    <style>
        .bg-pastel-blue { background-color: #A7C7E7; }
        .bg-pastel-green { background-color: #A9E2A9; }
        .bg-pastel-yellow { background-color: #F8E28C; }
        .text-pastel-orange { color: #FF9E3D; }
        .text-dark-gray { color: #333333; }
    </style>
</head>
<body class="bg-pastel-blue text-gray-800 flex flex-col min-h-screen">
    <nav class="bg-pastel-green p-4 shadow-lg">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <span class="text-xl font-semibold text-dark-gray">Admin Manager</span>
            <div class="flex gap-6">
                <a href="./home.php" class="text-gray-700 hover:text-pastel-orange">Event's List</a>
                <a href="./acc.php" class="text-gray-700 hover:text-pastel-orange font-bold">Admin Account</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-6 flex-grow">
        <h1 class="text-3xl font-bold text-center text-dark-gray mb-6">Edit Admin Account</h1>

        <form action="../service/auth.php" method="post" class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Phone</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" placeholder="Isi jika ingin mengganti password" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="cpassword" placeholder="Confirm Password" class="w-full p-2 border rounded-md">
            </div>
            <div class="flex justify-between">
                <button type="submit" name="type" value="edit" class="bg-pastel-green px-4 py-2 rounded-md">Submit</button>
                <a href="./acc.php" class="bg-red-500 px-4 py-2 rounded-md text-white">Cancel</a>
                <input type="reset" class="bg-blue-400 px-4 py-2 rounded-md text-white" value="Reset">
            </div>
        </form>
    </main>
    <footer class="bg-pastel-green text-center p-4 mt-6">
        <p class="text-sm text-black">&copy; 2025 Indah Callista Excella. All rights reserved.</p>
    </footer>
</body>
</html>
