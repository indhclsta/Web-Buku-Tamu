<?php 
session_start();

include "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $type = $_POST['type'];
    
    switch($type){
        case 'form':
            form();
            break;

        case 'data':
            scan();
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
