<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];
$tabel = $_GET['tabel'];
$master = $_GET['master'];

$sql = "DELETE FROM `$tabel` WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    $sql = "SET @autoid := 0";
    $conn->query($sql);
    $sql = "UPDATE `$tabel` SET id = @autoid := (@autoid + 1)";
    $conn->query($sql);
    $sql = "ALTER TABLE `$tabel` AUTO_INCREMENT = 1";
    $conn->query($sql);
}

$conn->close();

// Redirect kembali ke halaman form
header("Location: ../$master");
exit();
?>
