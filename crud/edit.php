<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "magang_syamrabu");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $tabel = $_GET['tabel'];
        $kolom = $_GET['kolom'];
        $master = $_GET['master'];
        $isi = $_POST['isi']; // Pastikan sesuai dengan form input

        $sql = "UPDATE `$tabel` SET `$kolom`='$isi' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            // Redirect kembali ke halaman form
            header("Location: ../$master");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>
