<?php
include "../service/connection.php";

session_start();
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //GET METHOD: menunjukan data dari table client
    if(!isset($_GET['id'])){
        header('location: ./acc.php');
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT username,email,phone,password FROM admin WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(!$row){
        header('location: ./acc.php');
        exit;
    }

    $name= $row['username'];
    $email= $row['email'];
    $phone= $row['phone'];
    $password= $row['password'];
} else{
    header('location: ./acc.php');
    $_SESSION['error'] = 'Data tidak ditemukan';
    exit;
}
?>


<!DOCTYPE html>
<html class="bg-slate-900 font-ubuntu" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
</head>
<body class=" text-white ">
<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
  </a>
  <div class="flex md:order-2">
    <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
      </svg>
      <span class="sr-only">Search</span>
    </button>
    
    <button data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-search" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
      
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="./home.php"  class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Event's List</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Admin Account's</a>
        </li>
        
      </ul>
    </div>
  </div>
</nav>
    <div class="mx-14 mt-[3rem]">
        <h2 class="text-[3rem] mb-7 font-bold">Update Data</h2>
        <?php
  if (isset($_SESSION['success'])) {
    echo "<script>
        Swal.fire({
            title: 'Success',
            text: '" . $_SESSION['success'] . "',
            icon: 'success',
            timer: 1000, // 2 seconds
            showConfirmButton: false
        });
    </script>";
    unset($_SESSION['success']);
  } else if (isset($_SESSION['error'])) {
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: '" . $_SESSION['error'] . "',
            icon: 'error',
            timer: 1000, // 2 seconds
            showConfirmButton: false
        });
    </script>";
    unset($_SESSION['error']);
  }
  ?>


        <form action="../service/auth.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="my-3">
                <label class="text-[1.2rem] " for="">Name</label>
                <div>
                    <input class="w-[100%] bg-zinc-700 placeholder:p-3 p-3 rounded h-[3rem]" placeholder="Masukkan Nama" type="text" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="my-3">
                <label class="text-[1.2rem] " for="">Email</label>
                <div>
                    <input class="w-[100%] bg-zinc-700 placeholder:p-3 p-3 rounded h-[3rem]" placeholder="Masukkan Email" type="text" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="my-3">
                <label class="text-[1.2rem] " for="">Phone</label>
                <div>
                    <input class="w-[100%] bg-zinc-700 placeholder:p-3 p-3 rounded h-[3rem]" placeholder="Masukkan No.Tlp" type="text" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>
            <div class="my-3">
                <label class="text-[1.2rem] " for="">Password</label>
                <div>
                    <input class="w-[100%] bg-zinc-700  p-3 rounded h-[3rem]"  type="password" name="password" placeholder="Isi jika ingin mengganti password">
                </div>
            </div>
            <div class="my-3">
                <label class="text-[1.2rem] " for="">Confirm Password</label>
                <div>
                    <input class="w-[100%] bg-zinc-700  p-3 rounded h-[3rem]"  type="password" name="cpassword" placeholder="Confirm Password">
                </div>
            </div>
            <div class="flex justify-end m-10">
                <div class="mx-4">
                    <button type="submit" name="type" value="edit" class="btn btn-success">Submit</button>
                </div>
                <div class="mx-4">
                    <a role="button" class="btn btn-error" href="./acc.php">Cancel</a>
                </div>
                <div class="mx-4">
                    <input type="reset" class="btn btn-info" value="Reset">
                </div>
            </div>
        </form>
    </div>
</body>
</html>