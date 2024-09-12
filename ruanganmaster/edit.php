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
        $ruangan = $_POST['ruangan'];
        
        $sql = "UPDATE ruangan SET ruangan='$ruangan' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            
        $conn->close();
        // Redirect kembali ke halaman form
        header("Location: ../master_ruangan.php");
        exit();

        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>
