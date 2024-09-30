<?php
if (isset($_POST['imgBase64'])) {
    // Koneksi ke database
    $servername = "localhost"; // ganti dengan server Anda
    $username = "username"; // ganti dengan username database Anda
    $password = "password"; // ganti dengan password database Anda
    $dbname = "masterruangan"; // ganti dengan nama database Anda

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data gambar dari Base64
    $image_parts = explode(";base64,", $_POST['imgBase64']);
    $image_base64 = base64_decode($image_parts[1]);

    // Beri nama file unik untuk setiap tanda tangan
    $fileName = uniqid() . '.png';

    // Simpan gambar ke dalam kolom tanda_tangan_pengajuan
    $stmt = $conn->prepare("INSERT INTO form_pengajuan (tanda_tangan_pengajuan) VALUES (?)");
    $stmt->bind_param("b", $image_base64);

    if ($stmt->execute()) {
        echo "Tanda tangan berhasil disimpan!";
    } else {
        echo "Gagal menyimpan tanda tangan: " . $stmt->error;
    }

    // Tutup koneksi
    $stmt->close();
    $conn->close();
} else {
    echo "Tidak ada data yang diterima.";
}
?>
