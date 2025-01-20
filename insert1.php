<?php
session_start();
include "service/connection.php";

if(isset($_POST['data'])){

    $item = $_POST['data'];

    $sql = "INSERT INTO reports(nama, date, time, fid_events) VALUES(?, ?, ?, ?)";
    $stmt = $conn -> prepare($sql);

    if($stmt){
        if (count($item) === 4) {
            $stmt->bind_param($item[0], $item[1], $item[2], $item[3]);
            $stmt->execute();
        } else {
            echo "Data tidak valid: ";
            print_r($item);
            echo "<br>";
        }
    }
    
header("location: index.php");
    
}
$conn->close();
?>