<?php
include 'koneksi.php';

if (isset($_GET['no'])) {
    $no = $_GET['no'];

    // Query untuk menghapus data
    $query = "DELETE FROM data_mahasiswa WHERE no = $no";
    mysqli_query($koneksi, $query);

    // Redirect kembali ke index.php
    header("Location: index.php");
}
?>

