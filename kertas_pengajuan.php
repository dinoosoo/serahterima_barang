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
            height: 1050px; /* Tinggi area tanda tangan */
            display: flex;
            flex-direction: column;
            align-items: flex-end; /* Mengatur agar elemen dalam flex berada di kanan */
        }
        .second-signature {
        margin-top: 20px;
        border-top: 1px solid black; /* Garis pemisah */
        padding-top: 10px; /* Jarak antara teks dan garis */
        }
        .second-signature {
        margin-top: 20px; /* Jarak atas */
        text-align: right; /* Mengatur teks agar rata kanan */
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
            width: calc(90% - 10mm);
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 10mm;
            margin-right:10mm;
        }

        .data-table {
            width: calc(100% - 20mm);
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
    </style>

</head>
<body>
    <div class="button-group">
        <button class="print-button" onclick="window.print()">Print</button>
        <button class="back-button" onclick="window.location.href='serah_pengajuan.php?id=<?php echo urlencode(isset($_GET['id']) ? $_GET['id'] : ''); ?>&jenis_berkas=<?php echo urlencode(isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''); ?>';">Back</button>

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
<table class="data-table">
        <table class="data-table" style="margin-left: auto; margin-right: auto;">

            <thead>
            </thead>
            <tbody>
        <tr>
            <th>Unit / Ruangan</th>
            <th></th>        
        </tr>
        <tr>
            <th>Nama Aplikasi</th>
            <th></th>
        </tr>
        <tr>
            <th>Kepada</th>
            <th>Instalasi IT</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="2">Topik</th>
        </tr>
        <tr>
            <th colspan="2">Rincian:</th> <!-- Menggunakan colspan -->
        </tr>
            </tbody>
        </table>
        
        </tr>

<div class="signature">
    <td style="text-align: center;">
    <p style="margin: 0;">Mengetahui</p>
    <p>Kepala Unit/Ruangan</p>
    <p>...............</p>
    <p style="margin-top: 50px;">__________________</p>
    <p style="margin: 0;">NIP. ............... ...............</p>
</td>
</div>

    <div class="approval-table">
    <table>
        <caption></caption>
        <tbody>
            <tr>
                <th colspan="2" style="border: ">PERTIMBANGAN PERSETUJUAN</th>
            </tr>
            <tr>
                <td style="width: 50%; ">DISETUJUI</td>
                <td style="width: 50%; ">TIDAK DISETUJUI</td>
            </tr>
            <tr>
                <td style="width: 50%; ">1</td>
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
</div>



    <script>
        function changeTitle(title) {
            document.getElementById('serah-terima-title').innerText = title;
        }
    </script>
</body>
</html>
