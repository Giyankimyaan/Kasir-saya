<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "kasir";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['tambah_transaksi'])) {
    $tanggal_waktu = date('Y-m-d H:i:s'); 
    $nomor = rand(100000, 999999); 
    $nama = $conn->real_escape_string($_POST['nama']);
    $total = intval($_POST['total']);
    $bayar = intval($_POST['bayar']);
    $kembali = $bayar - $total;

    $sql = "INSERT INTO transaksi (tanggal_waktu, nomor, total, nama, bayar, kembali) 
            VALUES ('$tanggal_waktu', '$nomor', '$total', '$nama', '$bayar', '$kembali')";
    
    if ($conn->query($sql) === TRUE) {
        $pesan = "Transaksi berhasil ditambahkan!";
    } else {
        $pesan = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM transaksi ORDER BY id_transaksi DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .tabel-transaksi {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        .tabel-transaksi th, .tabel-transaksi td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .tabel-transaksi th {
            background-color: #f4f4f4;
            text-align: left;
        }
        .kembali-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Manajemen Transaksi</h1>

    <div class="form-container">
        <h2>Tambah Transaksi</h2>
        <form method="POST">
            <label for="nama">Nama Pelanggan:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>

            <label for="total">Total:</label><br>
            <input type="number" id="total" name="total" required><br><br>

            <label for="bayar">Bayar:</label><br>
            <input type="number" id="bayar" name="bayar" required><br><br>

            <button type="submit" name="tambah_transaksi">Simpan Transaksi</button>
        </form>
    </div>

    <?php if (isset($pesan)): ?>
        <p><strong><?php echo $pesan; ?></strong></p>
    <?php endif; ?>

    <h2>Daftar Transaksi</h2>
    <table class="tabel-transaksi">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal & Waktu</th>
                <th>Nomor</th>
                <th>Total</th>
                <th>Nama</th>
                <th>Bayar</th>
                <th>Kembali</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_transaksi']; ?></td>
                        <td><?php echo $row['tanggal_waktu']; ?></td>
                        <td><?php echo $row['nomor']; ?></td>
                        <td>Rp<?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td>Rp<?php echo number_format($row['bayar'], 0, ',', '.'); ?></td>
                        <td>Rp<?php echo number_format($row['kembali'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Belum ada transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php" class="kembali-button">Kembali</a>
</body>
</html>
