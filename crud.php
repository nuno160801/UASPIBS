<?php
include 'koneksi.php';

// Handle different actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // Add new student
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];

        $stmt = $koneksi->prepare("INSERT INTO data_mahasiswa (nim, nama, prodi) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nim, $nama, $prodi);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        // Update existing student
        $no = $_POST['no'];
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];

        $stmt = $koneksi->prepare("UPDATE data_mahasiswa SET nim = ?, nama = ?, prodi = ? WHERE no = ?");
        $stmt->bind_param("sssi", $nim, $nama, $prodi, $no);
        $stmt->execute();
        $stmt->close();
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Delete student
    $no = $_GET['no'];
    $query = "DELETE FROM data_mahasiswa WHERE no = $no";
    mysqli_query($koneksi, $query);
}

// Query to get all students
$query = "SELECT * FROM data_mahasiswa";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        input[type="text"], button {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Data Mahasiswa</h1>

    <!-- Form Tambah Data -->
    <form method="POST" action="crud.php">
        <input type="hidden" name="action" value="add">
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
    <table>
        <tr>
            <th>NO</th>
            <th>NIM</th>
            <th>NAMA</th>
            <th>PRODI</th>
            <th>KELOLA</th>
        </tr>
        <?php
        $no = 1; // Initialize row number
        while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $no ?></td>
            <td><?= $row['nim'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['prodi'] ?></td>
            <td>
                <a href="crud.php?action=edit&no=<?= $row['no'] ?>">Edit</a> | 
                <a href="crud.php?action=delete&no=<?= $row['no'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php
            $no++; // Increment row number
        } ?>
    </table>

    <?php
    // Handle edit action
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $no = $_GET['no'];
        $stmt = $koneksi->prepare("SELECT * FROM data_mahasiswa WHERE no = ?");
        $stmt->bind_param("i", $no);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
    ?>
    <h1>Ubah Data Mahasiswa</h1>
    <form method="POST" action="crud.php">
        <input type="hidden" name="action" value="update">
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
            <a href="crud.php"><button type="button">Batal</button></a>
        </div>
    </form>
    <?php } ?>
</body>
</html>

