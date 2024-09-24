<?php
$id = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$sql = "SELECT * FROM form_pengajuan WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $alasan = $row['alasan'];
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = htmlspecialchars($email);
$judul = htmlspecialchars("Ini adalah judul");
$pesan = htmlspecialchars($alasan);

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'devitproduction@gmail.com';
    $mail->Password   = 'klxbwqztxxfmiqqv';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('devitproduction@gmail.com', 'DevIT Production');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = $judul;
    $mail->Body = $pesan;
    $mail->send();
    header("location:kertas_pengajuan.php?alert=berhasil&id=$id");
} catch (Exception $e) {
    header("location:kertas_pengajuan.php?alert=berhasil&id=$id");
}
