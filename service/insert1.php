<?php
session_start();
include "../service/connection.php";

if(isset($_POST['data'])){
    include "connection.php";  // Pastikan koneksi database dimuat
    
    $item = mysqli_real_escape_string($conn, $_POST['data']);

    // Periksa apakah token ada di tabel tamu
    $sql = "SELECT id FROM tamu WHERE token = '$item'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $fid_tamu = $row['id'];

        // Periksa apakah fid_tamu sudah ada di reports
        $checkSql = "SELECT fid_tamu FROM reports WHERE fid_tamu = $fid_tamu";
        $checkResult = $conn->query($checkSql);

        if($checkResult->num_rows == 0){
            // Masukkan data ke reports dengan memastikan event sesuai dengan tanggal
            $sql = "INSERT INTO reports (fid_tamu, date, time, events_fid) values(
                    (SELECT id FROM tamu WHERE token='$item'),
                    CURDATE(),
                    CURTIME(),
                    (SELECT fid_events FROM tamu where token='$item')
                    )";

            if($conn->query($sql)){
                $_SESSION['success'] = 'Data berhasil ditambahkan';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan saat menambahkan data';
            }
        } else {
            $_SESSION['error'] = 'Kamu sudah scan';
        }
    } else {
        $_SESSION['error'] = "Kamu tidak terdaftar";
    }

    // Redirect ke scan.php
    header("location: ../scan.php");
exit();
}