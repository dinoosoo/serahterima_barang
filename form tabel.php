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
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
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

        .table-container {
            margin-top: 20px;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <button class="btn btn-danger mr-1 mb-5" onclick="window.location.href='tabel.php'">Tutup Transaksi</button>
                            <button class="btn btn-primary ml-2 mb-5" onclick="window.location.href='tabel.php'">Kembali</button>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Formulir Serah Terima Barang</h1>
                            </div>

                            <!-- PHP for handling form submission -->
                            <?php
                            $conn = new mysqli("localhost", "root", "", "masterruangan");

                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            if (isset($_POST['signaturesubmit'])) {
                                $signature = $_POST['signature'];
                                $tanggal = $_POST['tanggal'];
                                $ruangan = $_POST['ruangan'];
                                $jenis = $_POST['jenis'];
                                $jumlah = $_POST['jumlah'];
                                $keterangan = $_POST['keterangan'];

                                if (empty($signature)) {
                                    $msg = "<div class='alert alert-danger'>Tidak ada data tanda tangan yang diterima.</div>";
                                } else {
                                    $signatureFileName = uniqid() . '.png';
                                    $signature = str_replace('data:image/png;base64,', '', $signature);
                                    $signature = str_replace(' ', '+', $signature);
                                    $data = base64_decode($signature);

                                    if ($data === false) {
                                        $msg = "<div class='alert alert-danger'>Gagal mendekode tanda tangan.</div>";
                                    } else {
                                        $dir = 'signatures';
                                        if (!file_exists($dir)) {
                                            mkdir($dir, 0777, true);
                                        }

                                        $file = $dir . '/' . $signatureFileName;
                                        if (file_put_contents($file, $data) === false) {
                                            $msg = "<div class='alert alert-danger'>Gagal menyimpan tanda tangan.</div>";
                                        } else {
                                            $sql = "INSERT INTO form_serah_terima (tanggal, ruangan, jenis, jumlah, keterangan, ttd) VALUES ('$tanggal', '$ruangan', '$jenis', '$jumlah', '$keterangan', '$file')";

                                            if ($conn->query($sql) === TRUE) {
                                                $msg = "<div class='alert alert-success'>Data berhasil disimpan.</div>";
                                            } else {
                                                $msg = "<div class='alert alert-danger'>Gagal menyimpan data: " . $conn->error . "</div>";
                                            }
                                        }
                                    }
                                }
                            }
                            ?>

                            <!-- Show message if set -->
                            <?php if (isset($msg)) echo $msg; ?>

                            <!-- Form -->
                            <form method="post" action="" onsubmit="return validateForm();" id="transactionForm">
                                <div class="form-container">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ruangan">Ruangan</label>
                                        <SELECT list="ruanganList" class="form-control" id="ruangan" name="ruangan" required>
                                        <datalist id="ruanganList">
                                            <?php
                                                // Koneksi ke database
                                                $conn = new mysqli("localhost", "root", "", "masterruangan");

                                                // Periksa koneksi
                                                if ($conn->connect_error) {
                                                    die("Koneksi gagal: " . $conn->connect_error);
                                                }

                                                // Ambil data dari tabel ruangan
                                                $sql = "SELECT id, ruangan FROM ruangan";
                                                $result = $conn->query($sql);

                                                // Loop melalui hasil dan buat opsi dalam datalist
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value=\"" . $row["ruangan"] . "\">" . $row["ruangan"] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option>No data</option>";
                                                }

                                                // Tutup koneksi
                                                $conn->close();
                                            ?>
                                        </datalist>
                                            </SELECT>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis">Jenis</label>
                                        <input type="text" class="form-control" id="jenis" name="jenis" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                                    </div>
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

        <!-- Table Section -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5 table-container">
                            <h3>Data Serah Terima Barang</h3>

                            <?php
                            // Retrieve data for the table
                            $conn = new mysqli("localhost", "root", "", "masterruangan");

                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            $result = $conn->query("SELECT * FROM form_serah_terima ORDER BY id DESC");

                            if ($result->num_rows > 0) : ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Ruangan</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['tanggal']; ?></td>
                                            <td><?php echo $row['ruangan']; ?></td>
                                            <td><?php echo $row['jenis']; ?></td>
                                            <td><?php echo $row['jumlah']; ?></td>
                                            <td><?php echo $row['keterangan']; ?></td>
                                            <td><img src="<?php echo $row['ttd']; ?>" alt="Tanda Tangan" style="width: 100px;"></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>

                            <?php else : ?>
                                <p>Belum ada data yang disimpan.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    // Add JavaScript to handle signature pad
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    canvas.addEventListener('mousedown', () => isDrawing = true);
    canvas.addEventListener('mouseup', () => isDrawing = false);
    canvas.addEventListener('mousemove', draw);

    function draw(event) {
        if (!isDrawing) return;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(event.clientX - canvas.offsetLeft, event.clientY - canvas.offsetTop);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(event.clientX - canvas.offsetLeft, event.clientY - canvas.offsetTop);
    }

    document.getElementById('clearSignature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('signature').value = '';
    });

    document.getElementById('transactionForm').addEventListener('submit', () => {
        const signatureData = canvas.toDataURL('image/png');
        document.getElementById('signature').value = signatureData;
    });

    function validateForm() {
        // Implement form validation if needed
        return true;
    }
</script>

</html>
