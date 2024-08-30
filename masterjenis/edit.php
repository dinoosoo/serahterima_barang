<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa conn
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
};

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $jenis = $_POST['jenis'];
        
        $sql = "UPDATE tjenis SET jenis='$jenis' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            
        $conn->close();
        // Redirect kembali ke halaman form
        header("Location: ../master jenis.php");
        exit();

        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>
