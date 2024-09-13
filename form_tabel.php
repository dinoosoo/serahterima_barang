<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Formulir Serah Terima Barang</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        #canvasDiv {
            position: relative;
            border: 2px dashed grey;
            height: 200px;
            margin-top: 10px;
            max-width: 100%;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-container {
        width: 80%;  /* Lebar form ditingkatkan */
        margin: 0 auto;  /* Posisikan form di tengah */
        padding: 20px;  /* Tambah padding untuk jarak yang nyaman */
        background-color: #f9f9f9;  /* Latar belakang yang lebih cerah */
        border-radius: 10px;  /* Tambahkan sudut yang membulat */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);  /* Bayangan halus untuk tampilan modern */
    }

        .form-control {
            border-radius: 4px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .error {
            border-color: red;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
                max-width: 100%;
            }
        }

        /* Custom styles for the heading */
        .custom-heading {
            font-weight: bold;
            border: 2px solid #007bff; /* Blue border color */
            border-radius: 8px;
            padding: 10px;
            background-color: #e9ecef; /* Light gray background */
            display: inline-block;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-12">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <?php $kembali = $_GET['kembali']; ?>
                                    <button class="btn btn-primary ml-2 mb-5" onclick="window.location.href='<?php echo $kembali;?>'">Kembali</button>                                   
                                    <?php
                                        $conn = new mysqli("localhost", "root", "", "masterruangan");

                                        if ($conn->connect_error) {
                                            die("Koneksi gagal: " . $conn->connect_error);
                                        }
                                    ?>

                                    <!-- Kotak untuk teks "Serah Terima Barang" dengan ukuran dan warna lebih pas -->
                                    <div class="border p-2 rounded mb-4 text-center" style="background-color: #e0e7ff; border-color: #b0c4de;">
                                        <h1 class="h5" style="color: #4a5568;"><strong>Serah Terima Barang</strong></h1>
                                    </div>


    <?php
$conn = new mysqli("localhost", "root", "", "masterruangan");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['signaturesubmit'])) {
    $signature = $_POST['signature'];
    $jenis_berkas = $_POST['jenis_berkas'];
    $tanggal = $_POST['tanggal'];
    $ruangan = $_POST['ruangan'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    if (empty($signature)) {
        $msg = "<div class='alert alert-danger' id='notification'>Tidak ada data tanda tangan yang diterima.</div>";
    } else {
        $signatureFileName = uniqid() . '.png';
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $data = base64_decode($signature);

        if ($data === false) {
            $msg = "<div class='alert alert-danger' id='notification'>Gagal mendekode tanda tangan.</div>";
        } else {
            $dir = 'signatures';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $file = $dir . '/' . $signatureFileName;
            if (file_put_contents($file, $data) === false) {
                $msg = "<div class='alert alert-danger' id='notification'>Gagal menyimpan tanda tangan.</div>";
            } else {
                // Ambil ID transaksi dari tabel periode yang kolom tanggal_selesai-nya masih kosong
                $sql = "SELECT id FROM priode WHERE tanggal_selesai IS NULL LIMIT 1";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $id_transaksi = $row['id'];
                    
                    // Masukkan data ke dalam tabel form_serah_terima, termasuk jenis_berkas dan id_transaksi
                    $sql = "INSERT INTO form_serah_terima (jenis_berkas, tanggal, ruangan, jenis, jumlah, keterangan, ttd, id_transaksi)
                            VALUES ('$jenis_berkas', '$tanggal', '$ruangan', '$jenis', '$jumlah', '$keterangan', '$file', '$id_transaksi')";

                    if ($conn->query($sql) === TRUE) {
                        $msg = "<div class='alert alert-success' id='notification'>Data berhasil disimpan.</div>";
                    } else {
                        $msg = "<div class='alert alert-danger' id='notification'>Gagal menyimpan data: " . $conn->error . "</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger' id='notification'>Tidak ada transaksi aktif yang ditemukan.</div>";
                }
            }
        }
    }
}

$conn->close();
?>

<!-- Show message if set -->
<?php if (isset($msg)) echo $msg; ?>

<!-- Form -->
<form method="post" action="" onsubmit="return validateForm();" id="transactionForm">
    <div class="form-container">
        <!-- Pilihan Barang Rusak atau Baru -->
        <div class="form-group">
            <label>Jenis Berkas</label><br>
            <input type="radio" id="barangBaru" name="jenis_berkas" value="baru" required>
            <label for="barangBaru">Barang Baru</label>
            <input type="radio" id="barangRusak" name="jenis_berkas" value="rusak" required>
            <label for="barangRusak">Barang Rusak</label>
        </div>
        <!-- Tanggal -->
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <!-- Ruangan -->
<div class="form-group">
    <label for="ruangan">Ruangan</label>
    <select class="form-control" id="ruangan" name="ruangan" required>
        <option value="" disabled selected></option> Opsi default
        <?php
            $conn = new mysqli("localhost", "root", "", "masterruangan");

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            $sql = "SELECT id, ruangan FROM ruangan";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"" . $row["ruangan"] . "\">" . $row["ruangan"] . "</option>";
                }
            } else {
                echo "<option value=''>No data available</option>";
            }

            $conn->close();
        ?>
    </select>
</div>
        <!-- Jenis -->
<div class="form-group">
    <label for="jenis">Jenis</label>
    <select class="form-control" id="jenis" name="jenis" required>
        <option value="" disabled selected></option> <!-- Opsi default -->
        <?php
            $conn = new mysqli("localhost", "root", "", "masterruangan");

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            $sql = "SELECT id, jenis FROM tjenis";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"" . $row["jenis"] . "\">" . $row["jenis"] . "</option>";
                }
            } else {
                echo "<option value=''>No data available</option>";
            }

            $conn->close();
        ?>
    </select>
</div>
        <!-- Jumlah -->
        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" required>
        </div>
        <!-- Keterangan -->
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
        </div>
        <!-- Tanda Tangan -->
        <div class="form-group">
            <label for="signature">Tanda Tangan</label>
            <div id="canvasDiv">
                <canvas id="signatureCanvas" width="400" height="200"></canvas>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="clearSignature">Clear</button>
        <input type="hidden" id="signature" name="signature">
        <button type="submit" class="btn btn-primary" name="signaturesubmit">Submit</button>
    </div>
</form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        var canvas = document.getElementById('signatureCanvas');
        var context = canvas.getContext('2d');
        var isDrawing = false;
        var x = 0;
        var y = 0;

        canvas.addEventListener('mousedown', function (e) {
            isDrawing = true;
            x = e.offsetX;
            y = e.offsetY;
        });

        canvas.addEventListener('mousemove', function (e) {
            if (isDrawing === true) {
                drawLine(context, x, y, e.offsetX, e.offsetY);
                x = e.offsetX;
                y = e.offsetY;
            }
        });

        canvas.addEventListener('mouseup', function () {
            if (isDrawing === true) {
                drawLine(context, x, y, x, y);
                isDrawing = false;
                updateSignatureInput();
            }
        });

        function drawLine(context, x1, y1, x2, y2) {
            context.beginPath();
            context.strokeStyle = 'black';
            context.lineWidth = 2;
            context.moveTo(x1, y1);
            context.lineTo(x2, y2);
            context.stroke();
        }

        function updateSignatureInput() {
            var dataURL = canvas.toDataURL();
            document.getElementById('signature').value = dataURL;
        }

        document.getElementById('clearSignature').addEventListener('click', function () {
            context.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('signature').value = '';
        });

        function validateForm() {
            var signature = document.getElementById('signature').value;
            if (!signature) {
                alert('Tanda tangan diperlukan!');
                return false;
            }
            return true;
        }

        // Auto-hide notification after 5 seconds
        setTimeout(function () {
            var notification = document.getElementById('notification');
            if (notification) {
                notification.style.transition = 'opacity 1s';
                notification.style.opacity = 0;
                setTimeout(function () {
                    notification.remove();
                }, 1000); // Delay to match the transition
            }
        }, 5000);
    </script>
</body>

</html>
