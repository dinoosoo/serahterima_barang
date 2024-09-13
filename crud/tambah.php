<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabel = $_GET['tabel'];
    $kolom = $_GET['kolom'];
    $master = $_GET['master'];
    $isi = $_POST['isi']; // Pastikan sesuai dengan form input

    // Siapkan dan bind
    $stmt = $conn->prepare("INSERT INTO `$tabel` (`$kolom`) VALUES (?)");
    $stmt->bind_param("s", $isi);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();

    // Redirect kembali ke halaman form
    header("Location: ../$master");
    exit();
}
?>
