<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "kasir";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_POST['kode_barang'])) {
    $kode_barang = $conn->real_escape_string($_POST['kode_barang']);

    $sql = "SELECT nama, harga FROM barang WHERE kode_barang = '$kode_barang'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['keranjang'][] = $row;
        $pesan = "Barang berhasil ditambahkan!";
    } else {
        $pesan = "Kode barang tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Barcode Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f8ff; /* AliceBlue */
            color: #333;
        }
        h1 {
            color: #1e90ff; /* DodgerBlue */
        }
        .form-container {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #e6f7ff; /* LightBlue */
            border: 1px solid #b3daff;
            border-radius: 10px;
        }
        .form-container label {
            color: #1e90ff; /* DodgerBlue */
        }
        .form-container input[type="text"] {
            padding: 10px;
            border: 1px solid #b3daff;
            border-radius: 5px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #1e90ff; /* DodgerBlue */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #1c86ee; /* DodgerBlue darker */
        }
        .keranjang {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        .keranjang th, .keranjang td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .keranjang th {
            background-color: #1e90ff; /* DodgerBlue */
            color: white;
            text-align: left;
        }
        .keranjang tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .keranjang tr:hover {
            background-color: #ddd;
        }
        .logout {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff6347; /* Tomato */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: #ff4500; /* OrangeRed */
        }
    </style>
</head>
<body>
    <h1>Sistem Kasir Barcode Scanner</h1>

    <div class="form-container">
        <form method="POST">
            <label for="kode_barang">Masukkan Kode Barang:</label>
            <input type="text" id="kode_barang" name="kode_barang" autofocus required>
            <button type="submit">Tambahkan</button>
        </form>
    </div>

    <?php if (isset($pesan)): ?>
        <p><strong><?php echo $pesan; ?></strong></p>
    <?php endif; ?>

    <h2>Keranjang Belanja</h2>
    <table class="keranjang">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['keranjang'])): ?>
                <?php $total = 0; foreach ($_SESSION['keranjang'] as $index => $item): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                        <td>Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php $total += $item['harga']; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong>Rp<?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3">Keranjang masih kosong.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a class="logout" href="logout.php">Logout</a>
</body>
</html>