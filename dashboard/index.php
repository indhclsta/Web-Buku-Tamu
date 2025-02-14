<?php
session_start();
if (isset($_SESSION['username']) == true) {
    header("location: index.php");
    exit();
}

include "../service/connection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = hash('sha256', $_POST['password']); // Hash the input password using SHA-256


    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password (hash atau plaintext)
        if ($password === $row['password'] || password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phone'] = $row['phone'];
            
            echo "<script>alert('Login berhasil!'); window.location.href='home.php';</script>";
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location.href='index.php';</script>";
    }
    $stmt->close();
    $conn->close();
    
}
?>



<!DOCTYPE html>
<html lang="en" class="font-ubuntu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    
    <style>
        .bg-pastel-blue { background-color: #A7C7E7; }
        .bg-pastel-green { background-color: #A9E2A9; }
        .bg-pastel-yellow { background-color: #F8E28C; }
        .text-dark-gray { color: #333333; }
        .btn:hover { background-color: #FF9E3D; transform: scale(1.05); transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-pastel-blue text-gray-800 flex flex-col min-h-screen items-center justify-center">
    <div class="w-96 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-bold text-dark-gray mb-6">Login</h2>
        <form action="" method="POST">
            <div class="mb-4 relative">
                <i class="fas fa-user absolute left-3 top-3 text-gray-500"></i>
                <input type="text" name="username" placeholder="Username" required class="w-full pl-10 p-2 border rounded-lg text-dark-gray">
            </div>
            <div class="mb-4 relative">
                <i class="fas fa-key absolute left-3 top-3 text-gray-500"></i>
                <input type="password" name="password" placeholder="Password" required class="w-full pl-10 p-2 border rounded-lg text-dark-gray">
            </div>
            <button type="submit" class="w-full bg-pastel-green text-black p-2 rounded-lg hover:bg-pastel-yellow">Login</button>
        </form>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
