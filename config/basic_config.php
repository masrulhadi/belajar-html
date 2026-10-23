<?php
// 1. Koneksi database pakai cara paling gampang (MySQLi Prosedural)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_belajar_php";

// Buka koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksinya berhasil atau error
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 2. Contoh cara ambil data dari tabel (misal tabel: users)
$query = mysqli_query($koneksi, "SELECT * FROM users");

// 3. Tampilkan datanya satu per satu pakai perulangan while
while($row = mysqli_fetch_assoc($query)) {
    echo "Nama: " . $row['nama'] . "<br>";
    echo "Email: " . $row['email'] . "<hr>";
}
?>