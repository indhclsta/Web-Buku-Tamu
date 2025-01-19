<?php
session_start();
include "service/connection.php";

if(isset($_POST['text'])){

    $text = $_POST['text'];

    // check if the token is exist
    $sql = "SELECT token FROM tamu WHERE token = '$text'";
    
    if($conn->query($sql) === TRUE){
        $sql = "INSERT INTO reports (fid_tamu, date, time, events_fid) VALUES (
        (SELECT id FROM tamu WHERE token = '$text'), 
        CURDATE(), 
        CURTIME(), 
        (SELECT fid_events FROM tamu WHERE token = '$text') 
        )";
    $_SESSION['success'] = 'data berhasil ditambahkan';
    }else{
       $_SESSION['error'] = $conn->error;
    }

    // redirect to scan.php
header("location: index.php");
}
$conn->close();