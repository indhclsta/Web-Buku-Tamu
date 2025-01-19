<?php
session_start();
include "service/connection.php";

if(isset($_POST['text'])){

    $text = $_POST['text'];

    // check if the token is exist
    $sql = "SELECT token FROM tamu WHERE token = '$text'";
    
    if($conn->query($sql)->num_rows > 0){
        $sql = "INSERT INTO reports (fid_tamu, date, time, events_fid) VALUES (
        (SELECT id FROM tamu WHERE token = '$text'), 
        CURDATE(), 
        CURTIME(), 
        (SELECT fid_events FROM tamu WHERE token = '$text') 
        )";
        $conn->query($sql);
    $_SESSION['success'] = 'data berhasil ditambahkan';
    }else{
       $_SESSION['error'] = $conn->error;
    }

    // redirect to scan.php
header("location: scan.php");
}
// $conn->close();