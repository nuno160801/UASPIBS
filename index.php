<?php
include 'koneksi.php';

// Query untuk mendapatkan data mahasiswa
$query = "SELECT * FROM data_mahasiswa";
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa</title>
</head>
<body>
    <h1>Data Mahasiswa</h1>

    <!-- Form Tambah Data -->
    <form method="POST" action="tambah.php">
        <div>
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" required>
        </div>
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div>
            <label for="prodi">Prodi:</label>
            <input type="text" id="prodi" name="prodi" required>
        </div>
        <div>
            <button type="submit">Simpan</button>
        </div>
    </form>

    <h2>Daftar Mahasiswa</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>NIM</th>
            <th>NAMA</th>
            <th>PRODI</th>
            <th>KELOLA</th>
        </tr>
        <?php
        $no = 1; // Inisialisasi nomor urut
        while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $no ?></td> <!-- Nomor diambil dari variabel $no -->
            <td><?= $row['nim'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['prodi'] ?></td>
            <td>
                <a href="ubah.php?no=<?= $row['no'] ?>">Edit</a> | 
                <a href="hapus.php?no=<?= $row['no'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php
            $no++; // Tambahkan 1 untuk nomor berikutnya
        } ?>
    </table>
</body>
</html>

