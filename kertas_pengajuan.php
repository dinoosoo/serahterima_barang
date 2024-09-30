<?php
session_start();
$id = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari tabel
$sql = "SELECT * FROM form_pengajuan WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
    $id_ruangan = $row['ruangan'];
    $id_aplikasi = $row['nama_aplikasi'];
    $id_topik = $row['topik'];
}

$sql = "SELECT ruangan FROM master_ruangan WHERE id=$id_ruangan";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $ruangan = $result->fetch_assoc();
}

$sql = "SELECT aplikasi FROM master_aplikasi WHERE id=$id_aplikasi";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $aplikasi = $result->fetch_assoc();
}

$sql = "SELECT topik FROM master_topik WHERE id=$id_topik";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $topik = $result->fetch_assoc();
}

$sql = "UPDATE form_pengajuan SET status='Sudah Terbuka' WHERE id=$id";
if ($status == "Belum Terbuka") {
    $conn->query($sql);
}

// Cek jika ada permintaan POST untuk memperbarui status
if (isset($_POST['simpan'])) {
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $alasan = $_POST['alasan'];

    $sql = "UPDATE form_pengajuan SET status='$status', deadline='$deadline', alasan='$alasan' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: kertas_pengajuan.php?id=$id");
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['kirim'])) {
    $tanda_tangan_persetujuan = $_POST['tanda_tangan_persetujuan'];

    $sql = "UPDATE form_pengajuan SET tanda_tangan_persetujuan='$tanda_tangan_persetujuan' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: kirim.php?id=$id");
    } else {
        echo "Error: " . $conn->error;
    }
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Serah Terima Barang</title>
    <style>
         table {
            width: 100%; /* Mengatur lebar tabel menjadi 100% dari kontainer */
            border-collapse: collapse; /* Menghilangkan jarak antar border */
        }
        th, td {
            border: 1px solid black; /* Menambahkan border pada sel */
            padding: 8px; /* Menambahkan padding di dalam sel */
            text-align: left; /* Mengatur teks rata kiri */
        }
        tbody tr:last-child {
            height: 150px; /* Mengatur tinggi untuk baris terakhir (sesuaikan sesuai kebutuhan) */
        }
        .signature {
            position: absolute; /* Mengatur posisi absolut */
            bottom: 85px; /* Jarak dari bawah */
            right: 160px; /* Jarak dari kanan */
            height: 1150px; /* Tinggi area tanda tangan */
            display: flex;
            flex-direction: column;
            align-items: flex-end; /* Mengatur agar elemen dalam flex berada di kanan */
        }
        .second-signature {
        margin-top: 20px;
        border-top: 1px solid black; /* Garis pemisah */
        padding-top: 10px; /* Jarak antara teks dan garis */
        }
        .approval-table {
            margin-top: 250px; /* Jarak antara NIP dan tabel persetujuan */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Mengatur agar teks berada di atas */
            height: 100vh; /* Membuat tinggi 100% dari viewport */
        }
        .floating-text {
            text-align: center; /* Mengatur teks ke tengah */
            position: absolute; /* Menggunakan posisi absolut */
            top: 20px; /* Mengatur jarak dari atas */
            left: 50%; /* Mengatur posisi kiri ke tengah */
            transform: translateX(-50%); /* Memindahkan teks ke kiri setengah lebar teks */
        }

        .container {
            width: 210mm; /* Lebar kertas A4 */
            height: 275mm; /* Tinggi kertas A4 */
            padding: 20mm;
            padding-top: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100%;

        }

        .button-group {
            position: absolute;
            top: 100px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .button-group button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-button {
            background-color: #007bff;
            color: white;
        }
        .back-button {
            background-color: red;
            color: white;
        }

        .period-button {
            background-color: #28a745;
            color: white;
        }

        @media print {
            .print-button,
            .period-button {
                display: none; /* Sembunyikan tombol saat cetak */
            }

            .data-table {
                width: 100%;
            }
        
            @page {
                size: A4;
                margin: 0;
            }
        }
        .btn-success {
            background-color: #28a745; /* Warna hijau */
            color: white; /* Teks putih */
            padding: 10px 20px; /* Padding untuk ukuran tombol */
            border: none; /* Menghilangkan border */
            border-radius: 5px; /* Membuat sudut tombol melengkung */
            cursor: pointer; /* Menampilkan kursor pointer */
        }

        .btn-danger {
            background-color: #dc3545; /* Warna merah */
            color: white; /* Teks putih */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.8; /* Efek hover */
        }
        /* Style untuk modal */
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%; /* Sesuaikan dengan kebutuhan */
            max-width: 600px; /* Maksimal lebar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px; /* Membuat sudut melengkung */
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px; /* Membuat sudut input melengkung */
            box-sizing: border-box; /* Agar padding terhitung dalam lebar */
        }

    </style>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<div class="button-group">
    <button class="print-button" onclick="window.print()">Print</button>
    <button class="btn-danger" onclick="window.location.href='serah_pengajuan.php?id=<?php echo urlencode(isset($_GET['id']) ? $_GET['id'] : ''); ?>&jenis_berkas=<?php echo urlencode(isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''); ?>';">Back</button>
    <hr style="color: black; length: 40px; margin: 10px 0;">
    <?php if ($_SESSION["role"] == "kabag") : ?>
    <button class="btn-success" onclick="tandatangan()">Signature</button>
<?php elseif ($status != "Disetujui" && $status != "Tidak Disetujui") : ?>
    <button class="btn-success" onclick="terimaPengajuan()">Receive</button>
    <button class="btn-danger" onclick="tolakPengajuan()">Reject</button>
<?php endif; ?>

</div>
    <div class="container">
        <img src="img/logorsud.jpeg" alt="Logo RSUD" class="logo">
        <h4 id="judul" style="text-align: center; text-decoration: underline 2px; text-weight: bold; margin-top: 0;">FORM PENGAJUAN</h4>
        <table class="data-table">
        <table style="margin-left: auto; margin-right: auto;">

            <thead>
            </thead>
            <tbody>
        <tr>
            <th style="width: 30%; font-weight: normal;">Unit / Ruangan</th>
            <th style="font-weight: normal;" ><?php echo $ruangan['ruangan'];?></th>        
        </tr>
        <tr>
            <th style="font-weight: normal;">Nama Aplikasi</th>
            <th style="font-weight: normal;"><?php echo $aplikasi['aplikasi'];?></th>
        </tr>
        <tr>
            <th style="font-weight: normal;">Kepada</th>
            <th style="font-weight: normal;"><?php echo $row['kepada'];?></th>
        </tr>
        <tr>
            <th style="font-weight: normal;">Tanggal</th>
            <th style="font-weight: normal;"><?php echo $row['tanggal'];?></th>
        </tr>
        <tr>
            <th style="font-weight: normal;">Topik</th>
            <th style="font-weight: normal;"><?php echo $topik['topik'];?></th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: top; font-weight: normal;">Rincian:
            <p ><?php echo $row['rincian'];?></p>
            </th> <!-- Menggunakan colspan -->
        </tr>
            </tbody>
        </table>
        </tr>

    <table>
        <tbody>
            <tr>
                <td style="border: 1px solid white;"></td>
                <td style="border: 1px solid white;"></td>
                <td style= "widht: 30%; text-align: center; font-weight: bold; border: 1px solid white;">
                    <p style="margin: 0px;">Mengetahui</p>
                    <h4 style="margin: 0px;">Kepala Unit/Ruangan</h4>
                    <img src=<?php echo $row['tanda_tangan'];?> style="width: 160px; height: auto; margin-bottom: -15px;"></img>
                    <p style="margin: 0; text-decoration: underline 2px;"><?php echo $row['nama'];?></p>
                    <p style="margin: 0; text-align: left;">NIP :<?php if ($row['nip']) { echo $row['nip'];} else {echo "-";}?></p>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid white;" colspan="3">
                    <hr style="border: none; border-top: 1px dashed black; width: 100%;">
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid white;"></td>
                <td colspan="2" style="border: 1px solid white; border-bottom: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="width: 50%; border: 1px solid white; border-right: 1px solid black;"></td>
                <th colspan="2" style=" text-align: center">PERTIMBANGAN PERSETUJUAN</th>
            </tr>
            <tr>
                <td style="width: 50%;border: 1px solid white; border-right: 1px solid black;"></td>
                <td style="width: 25%; text-align: center">DISETUJUI 
                    <?php if ($row['status'] == "Disetujui") { echo "<i class='fas fa-check'></i>"; }; ?>
                </td>
                <td style="width: 25%; text-align: center">TIDAK DISETUJUI 
                    <?php if ($row['status'] == "Tidak Disetujui") { echo "<i class='fas fa-check'></i>"; }; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: 1px solid white; border-right: 1px solid black;"></td>
                <td style="width: 50%;" colspan="2">
                    <?php 
                        if (!empty($row['alasan'])) {
                            echo htmlspecialchars($row['alasan']) . ', ' . htmlspecialchars($row['deadline']);
                        } else {
                            echo ".";
                        }
                    ?>
                </td>

            </tr>
            <tr>
                <td style="border: 1px solid white; border-right: 1px solid black; text-align: center; font-weight: bold;">
                <p style="margin: 0; font-weight: normal">Mengetahui</p>
                <p style="margin: 0; position: relative; z-index: 1;">Plt. kabag. Perencanaan dan Evaluasi</p>
                <p style="margin: 0; position: relative; z-index: 1;">Instalasi IT</p>
                    <!-- Tanda tangan otomatis ditempatkan lebih mepet -->
                    <img src="<?php echo $row['tanda_tangan_persetujuan']; ?>" alt="Tanda Tangan" style="width: 160px; height: auto; margin-bottom: -30px; margin-top: -30px; position: relative; z-index: 0;">
                    
                    <!-- Nama dengan jarak dekat ke garis -->
                    <p  style="margin: 0; text-decoration: underline 2px; position: relative; z-index: 1;">Djamal Abdul Nasir, S.Kom</p>

                    <!-- Garis dan NIP -->
                    <p style="margin: 0; position: relative; z-index: 1;">NIPPPK. 198305282023211008</p>
                </td>
                <td style="text-align: center; font-weight: bold;" colspan="2">
                    <p style="margin: 0; font-weight: normal">Bangkalan, <?php echo $row['tanggal'];?></p>
                    <p style="margin: 0; position: relative; z-index: 1;">Kepala</p>
                    <p style="margin: 0; position: relative; z-index: 1;">Instalasi IT</p>
                    <img src="img/ttd baru.webp" alt="Tanda Tangan" style="width: 160px; height: auto; margin-bottom: -30px; margin-top: -30px; position: relative; z-index: 0;">

                    <!-- Nama dengan jarak dekat ke garis -->
                    <p  style="margin: 0; text-decoration: underline 2px; position: relative; z-index: 1;">Djamal Abdul Nasir, S.Kom</p>

                    <!-- Garis dan NIP -->
                    <p style="margin: 0; position: relative; z-index: 1;">NIPPPK. 198305282023211008</p>
                </td>
        </tr>
        </tbody>
    </table>

    
<div id="tandatangan" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="tutupmodal()">&times;</span>
        <form method="post">
        
        <button name="kirim" type="submit" class="btn-success" onclick="tutupmodal()" style="margin-top: 10px;">Send</button>
        </form>
    </div>
</div>    
            <!-- Modal -->
<div id="dateModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form method="post">
        <label for="deadline" style="color: black;">Deadline Pengerjaan</label>
        <input name="deadline" type="date" id="tanggalDiterima" class="form-control" style="margin-bottom: 10px;">
        <label for="alasan" style="color: black;">Catatan</label>
        <input name="alasan" type="text" id="alasanPenolakan" class="form-control" placeholder="Masukkan alasan" style="width: 100%; padding: 10px; font-size: 16px;">
        <input type="hidden" name="status" value="Disetujui">
        <button name="simpan" type="submit" class="btn-success" onclick="saveDate()" style="margin-top: 10px;">Save</button>
        </form>
    </div>
</div>
<!-- Modal untuk input alasan penolakan -->
<div id="alasanModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeAlasanModal()">&times;</span>
        <form method="post">
        <label for="alasan" style="color: black;">Alasan</label>
        <input name="alasan" type="text" id="alasanPenolakan" class="form-control" placeholder="Masukkan alasan" style="width: 100%; padding: 10px; font-size: 16px;">
        <input type="hidden" name="status" value="Tidak Disetujui">
        <button name="simpan" type="submit" class="btn-success" onclick="saveAlasan()" style="margin-top: 10px;">Save</button>
        </form>
    </div>
</div>


    <script>
function tandatangan() {
    // Buka modal saat tombol ditekan
    document.getElementById("tandatangan").style.display = "block";
}

function tututpmodal() {
    document.getElementById("tandatangan").style.display = "none";
}

function terimaPengajuan() {
    // Buka modal saat tombol ditekan
    document.getElementById("dateModal").style.display = "block";
}

function saveDate() {
    // Tutup modal setelah simpan
    closeModal();
}

function closeModal() {
    document.getElementById("dateModal").style.display = "none";
}


function tolakPengajuan() {
    // Buka modal untuk alasan penolakan
    document.getElementById("alasanModal").style.display = "block";
}

function saveAlasan() {
    var alasan = document.getElementById("alasanPenolakan").value;

    if (alasan) {
        var id = "<?php echo urlencode(isset($_GET['id']) ? $_GET['id'] : ''); ?>";
        var jenisBerkas = "<?php echo urlencode(isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''); ?>";
        
        // Redirect dengan alasan penolakan
        window.location.href = 'serah_pengajuan.php?id=' + id + '&jenis_berkas=' + jenisBerkas + '&alasan=' + encodeURIComponent(alasan);
    } else {
        alert("Harap masukkan alasan penolakan.");
    }

    // Tutup modal setelah menyimpan alasan
    closeAlasanModal();
}

function closeAlasanModal() {
    document.getElementById("alasanModal").style.display = "none";
}

</script>

    <script>
        function changeTitle(title) {
            document.getElementById('serah-terima-title').innerText = title;
        }
    </script>
</body>
</html>
