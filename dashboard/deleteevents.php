<?php
include '../service/connection.php'; // Pastikan file ini ada dan berisi koneksi ke database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan ID adalah angka untuk keamanan

    // Query untuk menghapus data berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Event berhasil dihapus!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus event!'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.history.back();</script>";
}

$conn->close();
?>
