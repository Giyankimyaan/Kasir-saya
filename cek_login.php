<?php
session_start();


include 'config.php';


$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM user WHERE username=? AND password=?";
$stmt = mysqli_prepare($koneksi, $sql);


mysqli_stmt_bind_param($stmt, "ss", $username, $password);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


$cek = mysqli_num_rows($result);

if ($cek > 0) {
    // Mengambil data user
    $data = mysqli_fetch_assoc($result);

    // Memastikan key 'level' ada dalam array $data
    if (isset($data['level'])) {
        // Cek jika user login sebagai admin
        if ($data['level'] == "1") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "1";
            header("location:crud_barang.php");
        }
        // Cek jika user login sebagai kasir
        else if ($data['level'] == "2") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "2";
            header("location:kasir.php");
        }
    } else {
        header("location:index.php?pesan=gagal");
    }
} else {
    header("location:index.php?pesan=gagal");
}

?>
