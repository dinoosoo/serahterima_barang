<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Serah Terima Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
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

        .data-table td:last-child {
            width: 90px; /* Menentukan lebar kolom TTD sesuai kebutuhan */
            text-align: left; /* Menyelaraskan teks ke kiri */
            position: relative;
            z-index: 10; /* Memastikan TTD berada di atas elemen lain jika ada tumpang tindih */
            padding-top: 10px; /* Menambahkan jarak di atas TTD */
        }

        .data-table th:nth-child(2), 
        .data-table td:nth-child(2) {
            font-size: 17px;
            padding: 5px;
            white-space: nowrap;kolom tanggal
            width: 80px; /* Sesuaikan lebar kolom */
        }

        .data-table th:nth-child(3), 
.data-table td:nth-child(3) {
    font-size: 17px;
            padding: 5px;
            white-space:
    width: 80px; /* Lebar yang lebih besar untuk kolom Jenis */
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

        .data-table th, 
        .data-table td {
            border: 1px solid black !important; /* Border tabel hitam dengan !important */
            padding: 8px;
            text-align: center;
            vertical-align: middle;
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
        }.data-table img {
            max-width: 50px;
        }
    </style>

</head>
<body>
    <div class="button-group">
        <button class="print-button" onclick="window.print()">Print</button>
        <button class="back-button" onclick="window.location.href='tabeldetail.php?id=<?php echo urlencode(isset($_GET['id']) ? $_GET['id'] : ''); ?>&jenis_berkas=<?php echo urlencode(isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''); ?>';">Back</button>

    </div>
    <?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menentukan teks judul berdasarkan parameter jenis_berkas
$judul = "TANDA SERAH TERIMA BARANG RUSAK"; // Default title
if (isset($_GET['jenis_berkas'])) {
    $jenis_berkas = $_GET['jenis_berkas'];
    if ($jenis_berkas == "Baru") {
        $judul = "TANDA SERAH TERIMA BARANG BARU";
    }
}

// Memeriksa apakah ID dan jenis_berkas ada di GET
if (isset($_GET['id']) && isset($_GET['jenis_berkas'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $jenis_berkas = $_GET['jenis_berkas']; // Hindari SQL Injection pada string
    $no = 1;
    $sql = "SELECT * FROM form_serah_terima WHERE id_transaksi = '$id' AND jenis_berkas = '$jenis_berkas'";
    $result = $conn->query($sql);
} else {
    echo "Tidak ada data";
}
?>
    <div class="container">
        <img src="img/logorsud.jpeg" alt="Logo RSUD" class="logo">
        
        <div class="header-text">
            <h5 id="judul" class="bold"><?php echo $judul; ?></h5>
            <h5>Instalasi Informasi & Teknologi</h5>
            <h5>UOBK RSUD Syarifah Ambami Rato Ebu Bangkalan</h5>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Ruangan</th>
                    <th colspan="3">Barang</th>
                    <th rowspan="2">TTD</th>
                </tr>
                <tr>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php
                
                        if (isset($result) && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['tanggal'] . "</td>";
                                echo "<td>" . $row['ruangan'] . "</td>";
                                echo "<td>" . $row['jenis'] . "</td>";
                                echo "<td>" . $row['jumlah'] . "</td>";
                                echo "<td>" . $row['keterangan'] . "</td>";
                                echo "<td><img src='" . $row['ttd'] . "' alt='Tanda Tangan'></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data.</td></tr>";
                        }
                ?>
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
