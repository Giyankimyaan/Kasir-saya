<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "kasir";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $jumlah = $_POST['jumlah'];
        $kode_barang = $_POST['kode_barang'];

        $sql = "INSERT INTO barang (nama, harga, jumlah, kode_barang) VALUES ('$nama', '$harga', '$jumlah', '$kode_barang')";
        $conn->query($sql);
    } elseif (isset($_POST['edit'])) {
        $id_barang = $_POST['id_barang'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $jumlah = $_POST['jumlah'];
        $kode_barang = $_POST['kode_barang'];

        $sql = "UPDATE barang SET nama='$nama', harga='$harga', jumlah='$jumlah', kode_barang='$kode_barang' WHERE id_barang='$id_barang'";
        $conn->query($sql);
    } elseif (isset($_POST['hapus'])) {
        $id_barang = $_POST['id_barang'];
        $sql = "DELETE FROM barang WHERE id_barang='$id_barang'";
        $conn->query($sql);
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

$sql = "SELECT * FROM barang";
$result = $conn->query($sql);
if (!$result) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h1 class="text-center mb-4 mt-4">Program Admin</h1>
        <h2 class="text-center mb-4">Data Barang</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Tambah Barang</h5>
                <form method="POST" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="kode_barang" class="form-control" placeholder="Kode Barang" required>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="tambah" class="btn btn-success w-100">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Kode Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_barang'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['harga'] ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td><?= $row['kode_barang'] ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                                        <input type="text" name="nama" value="<?= $row['nama'] ?>" class="form-control mb-2" required>
                                        <input type="number" name="harga" value="<?= $row['harga'] ?>" class="form-control mb-2" required>
                                        <input type="number" name="jumlah" value="<?= $row['jumlah'] ?>" class="form-control mb-2" required>
                                        <input type="text" name="kode_barang" value="<?= $row['kode_barang'] ?>" class="form-control mb-2" required>
                                        <button type="submit" name="edit" class="btn btn-primary btn-sm">Edit</button>
                                        <button type="submit" name="hapus" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
