<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ruangan = $_POST["ruangan"];

    // Siapkan dan bind
    $stmt = $conn->prepare("INSERT INTO ruangan (ruangan) VALUES (?)");
    $stmt->bind_param("s", $ruangan);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
}

$conn->close();

// Redirect kembali ke halaman form
header("Location: ../master ruangan.php");
exit();
?>
