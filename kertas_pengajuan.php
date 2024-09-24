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
        .approval-table {
            margin-top: 150px; /* Jarak antara NIP dan tabel persetujuan */
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
            height: 420mm; /* Tinggi kertas A4 */
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }


        .header-text h5 {
            margin: 0;
            line-height: 1.4;
            font-weight: normal;
        }

        .header-text h5.bold {
            font-weight: bold; /* Membuat teks tebal untuk class 'bold' */
        }

        .data-table {
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 10mm;
            margin-right:10mm;
        }

        .data-table {
            border-collapse: collapse; /* Menghilangkan jarak antar border */
            margin-top: 20px;
        }

        .header-text {
            text-align: center;
            margin-top: 125px;
            position: relative;
                z-index: 2; /* Menempatkan teks di atas logo jika dibutuhkan */
            }

        .logo {
            display: block;
            width: 100%;
            max-width: 790px;
            height: auto;
            margin: 0 auto;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
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


    </style>

        
</head>
<body>
<div class="button-group">
    <button class="print-button" onclick="window.print()">Print</button>
    <button class="back-button" onclick="window.location.href='serah_pengajuan.php?id=<?php echo urlencode(isset($_GET['id']) ? $_GET['id'] : ''); ?>&jenis_berkas=<?php echo urlencode(isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''); ?>';">Back</button>
    
    <button class="btn-success btn" onclick="showDatePicker()">Terima</button>
        <div class="date-container" id="date-container">
            <input type="date" id="tanggalDiterima" class="form-control" onchange="saveDate()">
        </div>
    <button class="btn-danger" onclick="tolakPengajuan();">Tolak</button>
</div>



    <div class="container">
        <img src="img/logorsud.jpeg" alt="Logo RSUD" class="logo">
        
        <style>
    .underline {
        border-bottom: 2px solid black; /* Menambahkan garis bawah */
        display: inline-block; /* Mengatur elemen sebagai inline-block */
        padding-bottom: 0; /* Menghilangkan padding bawah */
    }
</style>

<div class="header-text">
    <h5 id="judul" class="bold underline">FORM PENGAJUAN PERUBAHAN APLIKASI</h5>
</div>

        <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "masterruangan");

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mengambil data dari tabel data_pengajuan
        $sql = "SELECT * FROM form_pengajuan WHERE id=5";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        ?>
        
        <table class="data-table" style="margin-left: auto; margin-right: auto;">

            <thead>
            </thead>
            <tbody>
        <tr>
            <th style="width: 30%; ">Unit / Ruangan</th>
            <th><?php echo $row['ruangan'];?></th>        
        </tr>
        <tr>
            <th>Nama Aplikasi</th>
            <th><?php echo $row['nama_aplikasi'];?></th>
        </tr>
        <tr>
            <th>Kepada</th>
            <th>Instalasi IT</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th><?php echo $row['tanggal'];?></th>
        </tr>
        <tr>
            <th>Topik</th>
            <th><?php echo $row['topik'];?></th>
        </tr>
        <tr>
            <th colspan="2" style="vertical-align: top;">Rincian: <?php echo $row['rincian'];?></th> <!-- Menggunakan colspan -->
        </tr>
            </tbody>
        </table>
        </tr>

    <table>
        <tbody>
            <tr>
                <td style="border: 1px solid white; border-bottom: 1px solid black;"></td>
                <td style="text-align: center; border: 1px solid white; border-bottom: 1px solid black; text-align: right;">
                    <p style="margin: 0px; margin-right: 10%;">Mengetahui</p>
                    <p style="margin: 0px;">Kepala Unit/Ruangan</p>
                    <img src=<?php echo $row['tanda_tangan'];?> style="margin: 0; width: 50%; height: auto;"></img>
                    <p style="margin: 0;">__________________</p>
                    <p style="margin: 0; margin-right: 30%;">NIP :<?php echo $row['nip'];?></p>
                </td>
            </tr>
            <tr>
                <th colspan="2" style="border: ">PERTIMBANGAN PERSETUJUAN</th>
            </tr>
            <tr>
                <td style="width: 50%; ">DISETUJUI</td>
                <td style="width: 50%; ">TIDAK DISETUJUI</td>
            </tr>
            <tr>
                <td style="width: 50%; ">.</td>
                <td style="width: 50%; "></td>
            </tr>
            <tr>
                <td  style="border: 1px solid white; border-right: 1px solid black;  background-color: white;"></td>
                <td>Bangkalan</td>
            </tr>
            <tr>
                <td style="border: 1px solid white; border-right: 1px solid black; background-color: white;"></td>
                <td style="text-align: center;">
                    <p style="margin: 0;">Kepala</p>
                    <p>Intalasi IT</p>
                    <p>...............</p>
                    <p>________________</P>
                    <p>NIPPPK. 198305282023211008</p>
                </td>
            </tr>
        </tbody>
    </table>
    
    <script>
    function showDatePicker() {
        var dateContainer = document.getElementById("date-container");
        var dateInput = document.getElementById("tanggalDiterima");
        dateContainer.style.display = "inline-block"; // Tampilkan date picker
        dateInput.focus(); // Fokus langsung ke date picker
    }

    function saveDate() {
        var tanggalDiterima = document.getElementById("tanggalDiterima").value;
        if (tanggalDiterima) {
            alert("Tanggal diterima: " + tanggalDiterima);
            // Tambahkan logika untuk menyimpan atau mengolah tanggal yang dipilih
        }
    }

    function tolakPengajuan() {
        var alasan = prompt("Masukkan alasan penolakan:");

        if (alasan !== null && alasan !== "") {
            var id = "<?php echo urlencode(isset($_GET['id']) ? $_GET['id'] : ''); ?>";
            var jenisBerkas = "<?php echo urlencode(isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''); ?>";
            
            window.location.href = 'serah_pengajuan.php?id=' + id + '&jenis_berkas=' + jenisBerkas + '&alasan=' + encodeURIComponent(alasan);
        } else {
            alert("Penolakan dibatalkan, alasan harus diisi.");
        }
    }
</script>

    <script>
        function changeTitle(title) {
            document.getElementById('serah-terima-title').innerText = title;
        }
    </script>
</body>
</html>
