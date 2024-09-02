<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
            max-width: 800px;
            margin: 0 auto;
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

        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
                max-width: 100%;
            }
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="sidebar-brand-text mx-3">INPUT FORM</div>
            </a>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>

                <div class="container-fluid">
                    <div class="content-wrapper">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1 class="m-0 text-dark">Formulir Serah Terima Barang</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Data Barang</h3>
                                            </div>
                                            <div class="card-body">

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

                                                $conn->close();
                                                ?>

                                                <!-- Show message if set -->
                                                <?php if (isset($msg)) echo $msg; ?>
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
                                                                <canvas id="signatureCanvas" width="400" height="200"></canvas>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary" id="clearSignature">Clear</button>
                                                        <input type="hidden" id="signature" name="signature">
                                                        <button type="submit" class="btn btn-primary" name="signaturesubmit">Submit</button>
                                                    </div>
                                                </form>

                                                <!-- Display Table (Hidden by default) -->
                                                <div id="transactionTable" style="display:none;">
                                                    <h3>Data Transaksi</h3>
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Ruangan</th>
                                                                <th>Jenis</th>
                                                                <th>Jumlah</th>
                                                                <th>Keterangan</th>
                                                                <th>Tanda Tangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Example static data, replace with PHP code to fetch data from the database -->
                                                            <tr>
                                                                <td>2024-08-29</td>
                                                                <td>HCU</td>
                                                                <td>Jenis A</td>
                                                                <td>10</td>
                                                                <td>Keterangan A</td>
                                                                <td><img src="signatures/example.png" alt="Signature" width="100"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#openTransaction').click(function () {
                $('#transactionForm').show();
                $('#closeTransaction').show();
                $('#openTransaction').hide();
                $('#transactionTable').hide();
            });

            $('#closeTransaction').click(function () {
                $('#transactionForm').hide();
                $('#closeTransaction').hide();
                $('#openTransaction').show();
                $('#transactionTable').show();
            });

            $('#clearSignature').click(function () {
                const canvas = document.getElementById('signatureCanvas');
                const context = canvas.getContext('2d');
                context.clearRect(0, 0, canvas.width, canvas.height);
                $('#signature').val('');
            });

            const canvas = document.getElementById('signatureCanvas');
            const context = canvas.getContext('2d');
            let drawing = false;

            canvas.addEventListener('mousedown', function (e) {
                drawing = true;
                context.beginPath();
                context.moveTo(e.offsetX, e.offsetY);
            });

            canvas.addEventListener('mousemove', function (e) {
                if (drawing) {
                    context.lineTo(e.offsetX, e.offsetY);
                    context.stroke();
                }
            });

            canvas.addEventListener('mouseup', function () {
                drawing = false;
                $('#signature').val(canvas.toDataURL('image/png'));
            });

            function validateForm() {
                const form = document.getElementById('transactionForm');
                if (!form.checkValidity()) {
                    alert('Please fill out all required fields.');
                    return false;
                }
                return true;
            }
        });
    </script>
</body>

</html>