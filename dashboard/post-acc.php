<?php
    session_start();
                if(isset($_SESSION['success'])){
                    echo "<script>Swal.fire('Success', '".$_SESSION['success']."', 'success');</script>";
                    unset($_SESSION['success']);
                } else if(isset($_SESSION['error'])){
                    echo "<script>Swal.fire('Error', '".$_SESSION['error']."', 'error');</script>";
                    unset($_SESSION['error']);
                }
                ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>

    <style>
        body {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        nav {
            background: linear-gradient(to right, #6b21a8, #4338ca);
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        main {
            width: 50%;
            max-width: 6xl;
            margin-top: 6rem;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        footer {
            background: linear-gradient(to right, #6b21a8, #4338ca);
            width: 100%;
            padding: 1rem 0;
            margin-top: auto;
            text-align: center;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        table th, table td {
        padding: 0.75rem; /* Perkecil padding */
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 0.875rem; /* Perkecil ukuran font */
        }
    </style>
</head>
<body>
    <nav>
        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center relative">
            <h1 class="text-2xl font-bold text-white">Formulir Event</h1>
        </div>
    </nav>

    <main>
        <h1 class="text-4xl font-bold text-white text-center mb-8">Tambah Event Baru</h1>

        <form action="../service/auth.php" method="post" id="eventForm" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Username:</label>
                <input type="text" name="username" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            
            <div class="mb-4">
                <label for="event" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" id="event" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-bold mb-2">No. Tlp:</label>
                <input type="number" name="phone" id="date" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-bold mb-2">Password:</label>
                <input type="password" name="password" id="date" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-bold mb-2">confirm Password:</label>
                <input type="password" name="cpassword" id="date" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>



            <button type="submit" name="type" value="account" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Buat akun</button>
        </form>

        
       
    </main>

    <footer>
        <p>&copy; 2025 Formulir Event</p>
    </footer>

</body>
</html>     