<?php
<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signature'])) {
        $signature = $_POST['signature'];

        // Menghapus bagian data URL (bagian sebelum koma)
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);

        // Decode string base64
        $data = base64_decode($signature);

        // Generate nama file yang unik
        $fileName = 'signature_' . uniqid() . '.png';

        // Definisikan path untuk menyimpan file
        $filePath = 'signatures/' . $fileName;

        // Simpan file gambar ke server
        if (file_put_contents($filePath, $data)) {
            echo json_encode(['success' => true, 'file' => $filePath]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan tanda tangan']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Tidak ada data tanda tangan ditemukan']);
    }
    exit;
}
?>

=======
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
?>
>>>>>>> 0390532d5c2fb091ec9fecbd116f70bbada7a741
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form Serah Terima Barang</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        #canvasDiv {
            position: relative;
            border: 2px dashed grey;
            height: 200px; /* Tinggi canvas lebih kecil */
            width: 100%; /* Lebar penuh */
        }

        .form-control-user {
            border-radius: 0 !important; /* Menghilangkan sudut bulat */
        }

        #canvas {
            display: block;
            margin: 0 auto;
        }

        .btn-custom {
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #4e73df; /* Warna utama */
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }

        .card {
            border-radius: 8px;
            position: relative;
        }

        .form-container {
            padding-top: 60px; /* Mengatur jarak padding untuk form */
        }

        select {
            padding: 0.5rem;
            font-size: 1rem;
        }

        .btn-close-transaksi {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-close-transaksi:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Tombol Tutup Transaksi -->
                        <button class="btn btn-secondary btn-close-transaksi">Tutup Transaksi</button>
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5 form-container">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Form Serah Terima Barang</h1>
                                    </div>
                                    <form class="user" id="signature-form" method="post">
                                        <div class="form-container">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="ruangan">Ruangan</label>
                                                <input list="ruanganList" class="form-control" id="ruangan" name="ruangan" required>
                                                <datalist id="ruanganList">
                                                    <option value="Bougenvil">
                                                    <option value="HCU">
                                                    <option value="UGD">
                                                    <option value="Camelia">
                                                    <option value="Edelweis">
                                                    <option value="Flamboyan">
                                                    <option value="Asoka">
                                                    <option value="Sakura">
                                                    <option value="ICU">
                                                </datalist>
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
                                                    <canvas id="canvas"></canvas>
                                                </div>
                                                <br>
                                                <button type="button" class="btn btn-danger btn-custom" id="reset-btn">Clear</button>
                                            </div>
                                            <input type="hidden" id="signature" name="signature">
                                            <button type="submit" class="btn btn-primary btn-user btn-block btn-custom">
                                                Kirim
                                            </button>
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

    <!-- Signature Pad and AJAX Handling -->
    <script>
        $(document).ready(() => {
            var canvasDiv = document.getElementById('canvasDiv');
            var canvas = document.getElementById('canvas');
            canvas.width = canvasDiv.clientWidth;
            canvas.height = canvasDiv.clientHeight;
            var context = canvas.getContext("2d");
            var paint = false;

            $('#canvas').mousedown(function(e) {
                var offset = $(this).offset();
                var mouseX = e.pageX - this.offsetLeft;
                var mouseY = e.pageY - this.offsetTop;

                paint = true;
                addClick(e.pageX - offset.left, e.pageY - offset.top);
                redraw();
            });

            $('#canvas').mousemove(function(e) {
                if (paint) {
                    var offset = $(this).offset();
                    addClick(e.pageX - offset.left, e.pageY - offset.top, true);
                    redraw();
                }
            });

            $('#canvas').mouseup(function(e) {
                paint = false;
            });

            $('#canvas').mouseleave(function(e) {
                paint = false;
            });

            var clickX = [];
            var clickY = [];
            var clickDrag = [];

            function addClick(x, y, dragging) {
                clickX.push(x);
                clickY.push(y);
                clickDrag.push(dragging);
            }

            $("#reset-btn").click(function() {
                context.clearRect(0, 0, canvas.width, canvas.height);
                clickX = [];
                clickY = [];
                clickDrag = [];
            });

            $("#signature-form").submit(function(e) {
                e.preventDefault();

                // Konversi canvas menjadi gambar
                var img = canvas.toDataURL("image/png");
                $("#signature").val(img);

                // Serialize form data
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: '', // Sesuaikan dengan URL skrip PHP yang memproses form
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response); // Log respons server untuk debugging
                        var res = JSON.parse(response); // Parse JSON response

                        if (res.success) {
                            alert('Form berhasil dikirim!');
                        } else {
                            alert('Error: ' + res.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error: ' + textStatus, errorThrown); // Log error jika ada
                    }
                });
            });

            function redraw() {
                context.clearRect(0, 0, context.canvas.width, context.canvas.height);
                context.strokeStyle = "#000000";
                context.lineJoin = "round";
                context.lineWidth = 2;

                for (var i = 0; i < clickX.length; i++) {
                    context.beginPath();
                    if (clickDrag[i] && i) {
                        context.moveTo(clickX[i - 1], clickY[i - 1]);
                    } else {
                        context.moveTo(clickX[i] - 1, clickY[i]);
                    }
                    context.lineTo(clickX[i], clickY[i]);
                    context.closePath();
                    context.stroke();
                }
            }
        });
    </script>
</body>

</html>
