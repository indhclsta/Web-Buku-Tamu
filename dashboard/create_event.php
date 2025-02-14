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
    <title>Create Event</title>
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

        .btn:hover { background-color: #FF9E3D; transform: scale(1.05); transition: all 0.3s ease; }
        input:focus { border-color: #FF9E3D; outline: none; transition: border-color 0.3s ease; }
    </style>
</head>
<body class="bg-pastel-blue text-gray-800 flex flex-col min-h-screen">

<nav class="bg-pastel-green p-4 shadow-lg">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <span class="text-xl font-semibold text-dark-gray">Event Manager</span>
        <div class="flex gap-6">
            <a href="home.php" class="text-gray-700 hover:text-pastel-orange">Event's List</a>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6 flex-grow">
    <h1 class="text-3xl font-bold text-center text-dark-gray mb-6">Tambah Event Baru</h1>
    
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

    <form action="../service/auth.php" method="post" id="eventForm" class="bg-white p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Event:</label>
            <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>
        
        <div class="mb-4">
            <label for="instansi" class="block text-gray-700 font-bold mb-2">Instansi:</label>
            <input type="text" name="instansi" id="instansi" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="start" class="block text-gray-700 font-bold mb-2">Start:</label>
            <input type="date" name="start" id="start" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="over" class="block text-gray-700 font-bold mb-2">Over:</label>
            <input type="date" name="over" id="over" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <button type="submit" name="type" value="event" class="bg-pastel-yellow text-dark-gray px-4 py-2 rounded-lg hover:bg-pastel-orange">Tambahkan Event</button>
    </form>
</main>

<footer class="bg-pastel-green text-center p-4">
    <p class="text-sm text-black">&copy; 2025 Indah Callista Excella. All rights reserved.</p>
</footer>

<script>
    lucide.createIcons();
</script>

</body>
</html>