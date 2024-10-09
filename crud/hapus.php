<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "magang_syamrabu");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];
$tabel = $_GET['tabel'];
$master = $_GET['master'];

$sql = "SELECT * FROM `$tabel` WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['nonaktif']== 0){
    $sql = "UPDATE `$tabel` SET nonaktif=1 WHERE id=$id";
    $conn->query($sql);
} else {
    $sql = "UPDATE `$tabel` SET nonaktif=0 WHERE id=$id";
    $conn->query($sql);
}
$conn->close();

// Redirect kembali ke halaman form
header("Location: ../$master");
exit();
?>
