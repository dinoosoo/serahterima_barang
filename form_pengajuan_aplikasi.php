<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form Pengajuan Perubahan Aplikasi</title>

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
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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

        .custom-heading {
            font-weight: bold;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 10px;
            background-color: #e9ecef;
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
                                    <button class="btn btn-primary ml-2 mb-5" onclick="window.location.href='index.php'">Kembali</button>

                                    <!-- Heading -->
                                    <div class="border p-2 rounded mb-4 text-center" style="background-color: #e0e7ff; border-color: #b0c4de;">
                                        <h1 class="h5" style="color: #4a5568;"><strong>Form Pengajuan Perubahan Aplikasi</strong></h1>
                                    </div>

                                    <?php
                                        // Koneksi ke database
                                        $conn = new mysqli("localhost", "root", "", "masterruangan");

                                        if ($conn->connect_error) {
                                            die("Koneksi gagal: " . $conn->connect_error);
                                        }

                                        // Proses saat form disubmit
                                        if (isset($_POST['signaturesubmit'])) {
                                            $nama = $_POST['nama'];
                                            $nip = $_POST['nip'];
                                            $email = $_POST['email'];  // Add this line for email
                                            $unit = $_POST['ruangan'];
                                            $aplikasi = $_POST['nama_aplikasi'];
                                            $kepada = $_POST['kepada'];
                                            $tanggal = $_POST['tanggal'];
                                            $topik = $_POST['topik'];
                                            $rincian = $_POST['rincian'];
                                            $signature = $_POST['signature'];

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
                                                        // Simpan data ke database
                                                        $sql = "INSERT INTO form_pengajuan (nama, nip, email, ruangan, nama_aplikasi, kepada, tanggal, topik, rincian, tanda_tangan) VALUES ('$nama', '$nip', '$email', '$unit', '$aplikasi', '$kepada', '$tanggal', '$topik', '$rincian', '$file')";
    
                                                        if ($conn->query($sql) === TRUE) {
                                                            $msg = "<div class='alert alert-success' id='notification'>Data berhasil disimpan.</div>";
                                                        } else {
                                                            $msg = "<div class='alert alert-danger' id='notification'>Gagal menyimpan data: " . $conn->error . "</div>";
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $conn->close();
                                        ?>

                <!-- Tampilkan pesan jika ada -->
                <?php if (isset($msg)) echo $msg; ?>

                <script>
                // Hilangkan pesan notifikasi setelah 3 detik
                document.addEventListener("DOMContentLoaded", function() {
                    const notification = document.getElementById('notification');
                    if (notification) {
                        setTimeout(function() {
                            notification.style.display = 'none';
                        }, 3000); // 3000 ms = 3 detik
                    }
                });
                </script>

                <form method="post" id="changeRequestForm">
                    <div class="form-container">
                        <!-- Nama -->
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <!-- NIP -->
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="number" class="form-control" id="nip" name="nip" required>
                </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>


                        <!-- Unit/Ruangan -->
                        <div class="form-group">
                            <label for="unit">Unit/Ruangan</label>
                            <select class="form-control" id="ruangan" name="ruangan" required>
                                <option value="" disabled selected></option> Opsi default
                                <?php
                                    $conn = new mysqli("localhost", "root", "", "masterruangan");

                                    if ($conn->connect_error) {
                                        die("Koneksi gagal: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT id, ruangan FROM master_ruangan";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=\"" . $row["ruangan"] . "\">" . $row["ruangan"] . "</option>";
                                        }
                                    }

                                    $conn->close();
                                ?>
                            </select>
                        </div>
                    <!-- Nama Aplikasi -->
                    <div class="form-group">
                        <label for="nama_aplikasi">Nama Aplikasi</label>
                        <select class="form-control" id="nama_aplikasi" name="nama_aplikasi" required>
                            <option value="" disabled selected></option> 
                            <?php
                                // Koneksi ke database master_aplikasi
                                $conn = new mysqli("localhost", "root", "", "masterruangan");

                                // Cek koneksi
                                if ($conn->connect_error) {
                                    die("Koneksi gagal: " . $conn->connect_error);
                                }

                                // Query untuk mengambil data dari master_aplikasi
                                $sql = "SELECT id, aplikasi FROM master_aplikasi";
                                $result = $conn->query($sql);

                                // Jika ada data, tampilkan dalam dropdown
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value=\"" . $row["aplikasi"] . "\">" . $row["aplikasi"] . "</option>";
                                    }
                                } 

                                // Tutup koneksi
                                $conn->close();
                            ?>
                        </select>
                    </div>

                    <!-- Kepada -->
                    <div class="form-group">
                        <label for="kepada">Kepada</label>
                        <input type="text" class="form-control" id="kepada" name="kepada" value="Instalasi IT" readonly>
                    </div>
                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    
                        <!-- Topik -->
                        <div class="form-group">
                            <label for="topik">Topik</label>
                            <select class="form-control" id="topik" name="topik" required>
                            <option value="" disabled selected></option> Opsi default
                                <?php
                                    // Ambil data dari tabel master_topik
                                    $conn = new mysqli("localhost", "root", "", "masterruangan");

                                    if ($conn->connect_error) {
                                        die("Koneksi gagal: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT id, topik FROM master_topik";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=\"" . $row["topik"] . "\">" . $row["topik"] . "</option>";
                                        }
                                    }

                                    $conn->close();
                                ?>
                            </select>
                        </div>
                        <!-- Rincian -->
                        <div class="form-group">
                            <label for="rincian">Rincian</label>
                            <textarea class="form-control" id="rincian" name="rincian" rows="3" required></textarea>
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
    document.addEventListener("DOMContentLoaded", function () {
        var canvas = document.getElementById('signatureCanvas');
        var ctx = canvas.getContext('2d');
        var drawing = false;
        var mousePos = { x: 0, y: 0 };
        var lastPos = mousePos;

        canvas.addEventListener('mousedown', function (e) {
            drawing = true;
            lastPos = getMousePos(canvas, e);
        }, false);

        canvas.addEventListener('mouseup', function (e) {
            drawing = false;
        }, false);

        canvas.addEventListener('mousemove', function (e) {
            mousePos = getMousePos(canvas, e);
            renderCanvas();
        }, false);

        canvas.addEventListener('touchstart', function (e) {
            mousePos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent('mousedown', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);

        canvas.addEventListener('touchend', function (e) {
            var mouseEvent = new MouseEvent('mouseup', {});
            canvas.dispatchEvent(mouseEvent);
        }, false);

        canvas.addEventListener('touchmove', function (e) {
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent('mousemove', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);

        document.body.addEventListener('touchstart', function (e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener('touchend', function (e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener('touchmove', function (e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);

        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            };
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        function renderCanvas() {
            if (drawing) {
                ctx.moveTo(lastPos.x, lastPos.y);
                ctx.lineTo(mousePos.x, mousePos.y);
                ctx.stroke();
                lastPos = mousePos;
            }
        }

        document.getElementById('clearSignature').addEventListener('click', function () {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.beginPath(); // Mulai path baru setelah kanvas dihapus
    document.getElementById('signature').value = ''; // Hapus nilai tanda tangan
    console.log("Signature cleared:", document.getElementById('signature').value); // Debugging
});

        document.getElementById('changeRequestForm').addEventListener('submit', function (e) {
            var dataUrl = canvas.toDataURL();
            document.getElementById('signature').value = dataUrl;
        });
    });
</script>

    
</body>

</html>
