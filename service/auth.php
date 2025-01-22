<?php 
session_start();

include "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $type = $_POST['type'];
    
    switch($type){
        case 'form':
            form();
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

