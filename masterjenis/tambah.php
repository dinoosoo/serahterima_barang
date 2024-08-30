<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis = $_POST["jenis"];

    // Siapkan dan bind
    $stmt = $conn->prepare("INSERT INTO tjenis (jenis) VALUES (?)");
    $stmt->bind_param("s", $jenis);

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
header("Location: ../master jenis.php");
exit();
?>
