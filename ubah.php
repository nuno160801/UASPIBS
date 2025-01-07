<?php
include 'koneksi.php';

// Ambil ID data yang akan diubah
if (isset($_GET['no'])) {
    $no = $_GET['no'];

    // Prepare statement to prevent SQL injection
    $stmt = $koneksi->prepare("SELECT * FROM data_mahasiswa WHERE no = ?");
    $stmt->bind_param("i", $no);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>
    <form method="POST" action="simpanUbah.php">
        <input type="hidden" name="no" value="<?= $data['no'] ?>">
        <div>
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" value="<?= $data['nim'] ?>" required>
        </div>
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
        </div>
        <div>
            <label for="prodi">Prodi:</label>
            <input type="text" id="prodi" name="prodi" value="<?= $data['prodi'] ?>" required>
        </div>
        <div>
            <button type="submit">Simpan</button>
            <a href="index.php"><button type="button">Batal</button></a>
        </div>
    </form>
</body>
</html>
