<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no = $_POST['no'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    // Prepare statement to prevent SQL injection
    $stmt = $koneksi->prepare("UPDATE data_mahasiswa SET nim = ?, nama = ?, prodi = ? WHERE no = ?");
    $stmt->bind_param("sssi", $nim, $nama, $prodi, $no);
    
    if (!$stmt->execute()) {
        die("Query failed: " . $stmt->error);
    }
    $stmt->close();

    // Redirect kembali ke index.php
    header("Location: index.php");
}
?>
