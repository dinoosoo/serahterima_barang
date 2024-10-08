<?php
$id = $_GET['id']; // Ambil ID dari URL
$conn = new mysqli("localhost", "root", "", "magang_syamrabu");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data berdasarkan ID
$sql = "SELECT * FROM form_pengajuan WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $alasan = $row['alasan'];
    $status = $row['status'];
}

// PHPMailer setup
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Pastikan email dan data lain sudah diambil dengan benar
$email = htmlspecialchars($email);
$judul = htmlspecialchars("Surat Anda " . $status);
$pesan = htmlspecialchars($alasan);

// Buat link menuju halaman pengajuan dengan ID yang relevan
$link_to_form = "http://localhost/TUGAS_TERKINI/kertas_pengajuan.php?alert=berhasil&id=" . urlencode($id);

// Tambahkan link ke dalam pesan email
$pesan .= "<br><br>Anda dapat melihat pengajuan Anda melalui link berikut: ";
$pesan .= "<a href='$link_to_form'>$link_to_form</a>";

$mail = new PHPMailer(true);

try {
    // Setup email server
    $mail->SMTPDebug = 0; // 2 for debugging, 0 for production
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'devitproduction@gmail.com'; // Ganti dengan email Anda
    $mail->Password   = 'klxbwqztxxfmiqqv'; // Ganti dengan password aplikasi
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Set email sender dan recipient
    $mail->setFrom('devitproduction@gmail.com', 'Kepala IT Syamrabu');
    $mail->addAddress($email);

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = $judul;
    $mail->Body = $pesan;

    // Kirim email
    $mail->send();
    
    // Redirect setelah email terkirim
    header("location:kertas_pengajuan.php?alert=berhasil&id=$id");

} catch (Exception $e) {
    // Jika gagal, tetap redirect tetapi bisa tambahkan logging untuk kesalahan
    header("location:kertas_pengajuan.php?alert=gagal&id=$id");
}
?>
