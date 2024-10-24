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
                                    <button class="btn btn-primary ml-2 mb-5" onclick="window.location.href='<?php echo $kembali;?>'">Back</button>                                   
                                    <?php
                                        $conn = new mysqli("localhost", "root", "", "magang_syamrabu");

                                        if ($conn->connect_error) {
                                            die("Koneksi gagal: " . $conn->connect_error);
                                        }
                                    ?>

                                    <!-- Kotak untuk teks "Serah Terima Barang" dengan ukuran dan warna lebih pas -->
                                    <div class="border p-2 rounded mb-4 text-center" style="background-color: #e0e7ff; border-color: #b0c4de;">
                                        <h1 class="h5" style="color: #4a5568;"><strong>Serah Terima Barang</strong></h1>
                                    </div>


                                    <?php
$conn = new mysqli("localhost", "root", "", "magang_syamrabu");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['signaturesubmit'])) {
    $signature = $_POST['signature'];
    $capturedImage = $_POST['capturedImage'];
    $jenis_berkas = $_POST['jenis_berkas'];
    $tanggal = $_POST['tanggal'];
    $ruangan = $_POST['ruangan'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // Validate if an image was captured
    if (empty($signature) || empty($capturedImage)) {
        $msg = "<div class='alert alert-danger' id='notification'>Tanda tangan dan foto diperlukan.</div>";
    } else {
        // Handle signature saving (same as before)
        $signatureFileName = uniqid() . '.png';
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureData = base64_decode($signature);

        $capturedFileName = uniqid() . '_photo.png';
        $capturedImage = str_replace('data:image/png;base64,', '', $capturedImage);
        $capturedImage = str_replace(' ', '+', $capturedImage);
        $capturedData = base64_decode($capturedImage);

        if ($signatureData === false || $capturedData === false) {
            $msg = "<div class='alert alert-danger' id='notification'>Gagal mendekode tanda tangan atau foto.</div>";
        } else {
            $dir = 'uploads';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $signatureFile = $dir . '/' . $signatureFileName;
            $capturedFile = $dir . '/' . $capturedFileName;

            // Save signature and image
            if (file_put_contents($signatureFile, $signatureData) !== false && file_put_contents($capturedFile, $capturedData) !== false) {
                //cari periode yang belum terisi
                $sql = "SELECT id FROM priode WHERE tanggal_selesai IS NULL LIMIT 1";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $id_transaksi = $row['id'];
                // Save both signature and captured image to the database
                $sql = "INSERT INTO form_serah_terima (jenis_berkas, tanggal, ruangan, jenis, jumlah, keterangan, ttd, photo, id_transaksi)
                        VALUES ('$jenis_berkas', '$tanggal', '$ruangan', '$jenis', '$jumlah', '$keterangan', '$signatureFile', '$capturedFile', '$id_transaksi')";

                if ($conn->query($sql) === TRUE) {
                    $msg = "<div class='alert alert-success' id='notification'>Data berhasil disimpan.</div>";
                } else {
                    $msg = "<div class='alert alert-danger' id='notification'>Gagal menyimpan data: " . $conn->error . "</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger' id='notification'>Gagal menyimpan tanda tangan atau foto.</div>";
            }
        }
    }
}


// Close connection after form submission
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
                <option value="" disabled selected>Pilih Ruangan</option> <!-- Opsi default -->
                <?php
                    $conn = new mysqli("localhost", "root", "", "magang_syamrabu");

                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    $sql = "SELECT id, ruangan FROM master_ruangan WHERE nonaktif=1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row["id"] . "\">" . $row["ruangan"] . "</option>";
                        }
                    }

                    $conn->close();
                ?>
            </select>
        </div>
        <!-- Jenis -->
        <div class="form-group">
            <label for="jenis">Jenis</label>
            <select class="form-control" id="jenis" name="jenis" required>
                <option value="" disabled selected>Pilih Jenis</option> <!-- Opsi default -->
                <?php
                    $conn = new mysqli("localhost", "root", "", "magang_syamrabu");

                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    $sql = "SELECT id, jenis FROM master_jenis WHERE nonaktif=1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row["id"] . "\">" . $row["jenis"] . "</option>";
                        }
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
    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" maxlength="50" required></textarea>
    <small id="wordCounter" class="form-text text-muted">0/50 Karakter</small>
</div>

<!-- Optional CSS to handle long words -->
<style>
    #keterangan {
        overflow-wrap: break-word; /* Word wrapping for long words */
        word-wrap: break-word; /* Deprecated, but supported in older browsers */
        word-break: break-word; /* Break words if they are too long */
    }
</style>
<!-- HTML for Camera Capture -->
<div class="form-group">
    <label for="camera">Menangkap Gambar</label><br>
    <button type="button" class="btn btn-success" id="startCamera" style="display: block; margin-bottom: 10px;">Mulai Camera</button>
    <button type="button" class="btn btn-danger" id="captureImage" style="display:none; margin-bottom: 10px;">Menangkap</button>
    <video id="video" width="320" height="240" autoplay style="display:none;"></video>
    <canvas id="photoCanvas" width="320" height="240" style="display:none;"></canvas>
    <!-- Elemen gambar untuk menampilkan pratinjau -->
    <img id="hasilGambar" src="<?php echo $isi['photo'];?>" alt="Foto" style="width: 320px; height: 240px; margin-bottom: 20px;">

    <!-- Input hidden untuk menyimpan gambar yang sudah ditangkap -->
    <input type="hidden" id="capturedImage" name="capturedImage" value="<?php echo $isi['photo'];?>">
</div>
<!-- Tanda Tangan -->
<div class="form-group">
        <label for="signature">Tanda Tangan</label>
        <div id="canvasDiv" style="display: flex; justify-content: center;">
            <canvas id="signatureCanvas" width="400" height="200"></canvas>
        </div>
</div>
        <button type="button" class="btn btn-danger" id="clearSignature">Clear</button>
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
    // Camera access and image capture logic
    const video = document.getElementById('video');
    const photoCanvas = document.getElementById('photoCanvas');
    const startCameraBtn = document.getElementById('startCamera');
    const captureImageBtn = document.getElementById('captureImage');
    const capturedImageInput = document.getElementById('capturedImage');
    const hasilGambar = document.getElementById('hasilGambar');

    startCameraBtn.addEventListener('click', function() {
        // Request access to the camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                video.srcObject = stream;
                video.style.display = 'block';
                captureImageBtn.style.display = 'inline-block';
                hasilGambar.style.display = 'none';
                startCameraBtn.style.display = 'none';
            })
            .catch(function(err) {
                console.log("Error accessing the camera: " + err);
            });
    });

    captureImageBtn.addEventListener('click', function() {
        // Draw the video frame onto the canvas
        const context = photoCanvas.getContext('2d');
        context.drawImage(video, 0, 0, photoCanvas.width, photoCanvas.height);
        
        // Convert the captured image to a base64 string
        const imageDataURL = photoCanvas.toDataURL('image/png');
        capturedImageInput.value = imageDataURL; // Save it in the hidden input
        
        // Display the captured image in the img element
        hasilGambar.src = imageDataURL;
        hasilGambar.style.display = 'block'; // Tampilkan gambar baru

        // Hide the video feed after capturing the image
        video.style.display = 'none';
        captureImageBtn.style.display = 'none';
        startCameraBtn.style.display = 'inline-block';
    });

</script>
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
        document.getElementById('keterangan').addEventListener('input', function () {
    var textLength = this.value.length;
    var maxLength = this.getAttribute('maxlength');
    document.getElementById('wordCounter').innerText = textLength + "/" + maxLength + " Karakter";
});

    </script>
</body>

</html>