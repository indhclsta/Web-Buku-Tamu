<?php
session_start();
include "../service/connection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #3b82f6, #9333ea); /* Gradien biru ke ungu */
            min-height: 100vh; /* Tinggi minimum layar penuh */
            display: flex; /* Aktifkan flexbox */
            flex-direction: column; /* Tata letak vertikal */
            align-items: center; /* Rata tengah horizontal */
            justify-content: center; /* Rata tengah vertikal */
            margin: 0; /* Hilangkan margin default */
            overflow-x: hidden; /* Sembunyikan overflow horizontal */
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            width: 80%;
            max-width: 1200px;
        }

        .signup-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 400px;
            flex-shrink: 0;
        }

        .signup-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 2.5rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f3f8ff;
            color: #333;
        }

        .form-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .form-group .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        .signup-btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: #596a85;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .signup-btn:hover {
            background: #48576c;
        }

    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-purple-700">
    <div class="w-96 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-center text-2xl font-bold mb-6">Login</h2>
        <form action="" method="POST">
            <div class="mb-4 relative">
                <i class="fas fa-user absolute left-3 top-3 text-gray-500"></i>
                <input type="text" name="username" placeholder="Username" required class="w-full pl-10 p-2 border rounded-lg">
            </div>
            <div class="mb-4 relative">
                <i class="fas fa-key absolute left-3 top-3 text-gray-500"></i>
                <input type="password" name="password" placeholder="Password" required class="w-full pl-10 p-2 border rounded-lg">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">Login</button>
        </form>
    </div>
</body>
</html>