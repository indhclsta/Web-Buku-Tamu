<?php 
session_start();

include "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $type = $_POST['type'];
    
    switch($type){
        case 'form':
            form();
            break;

        case 'login':
            login();
            break;

        default:
        header ("location: ../index.php");
        break;
    }
}

function form(){
    include "connection.php";
    $nama = $_POST['nama'];
    $event = $_POST['event'];
    $telepon = $_POST['telepon'];
    $token = $_POST['token'];

    $sql = "SELECT * FROM tamu WHERE nama = '$nama'";
    $result = mysqli_query($conn, $sql);
    if(!$result->num_rows > 0){
        $sql = "INSERT INTO tamu (nama, fid_events, level, token, telepon) VALUES ('$nama', $event, 'REGULAR', '$token', $telepon)";
        $result = mysqli_query($conn, $sql);
        if($result){
            $_SESSION['success'] = 'data berhasil ditambahkan';

        } else {
            $_SESSION['error'] = 'Data salah';
        }
        } else {
            $_SESSION['error'] = 'Data sudah ada';
        }

    header ("location: ../index.php");
    }

function scan(){
    include "connection.php";
    // check if the token is exist
    $sql = "SELECT token FROM tamu WHERE token = '$item'";


    if($conn->query($sql)->num_rows > 0){
        // check if fid_tamu already exists in reports
        $checkSql = "SELECT fid_tamu FROM reports WHERE fid_tamu = (SELECT id FROM tamu WHERE token = '$item')";
        if($conn->query($checkSql)->num_rows == 0){
            $sql = "INSERT INTO reports (fid_tamu, date, time, events_fid) VALUES (
            (SELECT id FROM tamu WHERE token = '$item'), 
            CURDATE(), 
            CURTIME(), 
            (SELECT fid_events FROM tamu WHERE token = '$item') 
            )";
            $conn->query($sql);
            $_SESSION['success'] = 'data berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'kamu sudah scan';
        }
    } else {
       $_SESSION['error'] = $conn->error;
    }

    // redirect to scan.php
header("location: ../scan.php");
}

function login(){
    include "connection.php";
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password =  $_POST['password']; //hash('sha256', $_POST['password']); // Hash the input password using SHA-256
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['success'] = 'Berhasil login';
        exit();
        header('location: ../dashboard/dashboard.php');
    } else {
        $_SESSION['error'] = 'Ada data yang salah';
    }
}

function register(){
    include "./connection.php";

    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']); // Hash the input password using SHA-256
    $cpassword = hash('sha256', $_POST['cpassword']); // Hash the input confirm password using SHA-256
    
    if ($password == $cpassword) {
        $sql = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO user (username, password)
                    VALUES ('$username', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                // mengkosongkan value setelah berhasil insert data
                $username = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
                exit();
            } else {
                echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        }
    } else {
        echo "<script>alert('Password Tidak Sesuai')</script>";
    }
}