<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM tjenis WHERE id=$id";

if($conn->query($sql) === TRUE){
    $sql = "SET @autoid :=0";
    $conn->query($sql);
    $sql = "UPDATE tjenis SET id = @autoid := (@autoid+1)";
    $conn->query($sql);
    $sql = "ALTER TABLE tjenis AUTO_INCREMENT = 1";
    $conn->query($sql);
    
    
}

$conn->close();

// Redirect kembali ke halaman form
header("Location: ../master_jenis.php");
exit();


?>