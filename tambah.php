<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    // Prepare statement to prevent SQL injection
    $stmt = $koneksi->prepare("INSERT INTO data_mahasiswa (nim, nama, prodi) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nim, $nama, $prodi);
    
    if (!$stmt->execute()) {
        die("Query failed: " . $stmt->error);
    }
    $stmt->close();

    // Redirect kembali ke index.php
    header("Location: index.php");
}
?>
