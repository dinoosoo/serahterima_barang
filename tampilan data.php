<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ADMIN SYAMRABU</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for tables -->
    <style>
        .table {
            color: #333;
        }
        .table th {
            background-color: #f8f9fc;
            color: #4e73df;
        }
        .table td {
            background-color: #fff;
        }
        .table thead th {
            border-bottom: 2px solid #4e73df;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #d1e7fd;
        }
        .table img {
            max-width: 50px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Merek -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <div class="sidebar-brand-text mx-3">ADMIN SYAMRABU <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>INPUT DATA</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="master_ruangan.php">Master Ruangan</a>
                        <a class="collapse-item" href="master_jenis.php">Master Jenis</a>
                        <a class="collapse-item" href="tampilan_data.php">Tampilkan Data</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">

            <!-- Nav Item - Tampilkan Data -->
            <li class="nav-item">
                <a class="nav-link" href="tampilan_data.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tampilkan Data</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="content-wrapper">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1 class="m-0 text-dark">Instalasi Informasi & Teknologi</h1>
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
                                                <h4 class="card-title">Data Barang</h4>
                                            </div>
                                            <div class="card-body">
                                                <?php
                                                // Koneksi ke database
                                                $conn = new mysqli("localhost", "root", "", "masterruangan");

                                                // Periksa koneksi
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
                                                            // Pastikan direktori 'signatures' ada
                                                            $dir = 'signatures';
                                                            if (!file_exists($dir)) {
                                                                mkdir($dir, 0777, true);
                                                            }

                                                            $file = $dir . '/' . $signatureFileName;
                                                            if (file_put_contents($file, $data) === false) {
                                                                $msg = "<div class='alert alert-danger'>Gagal menyimpan tanda tangan.</div>";
                                                            } else {
                                                                // Simpan data ke database
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

                                                $sql = "SELECT * FROM form_serah_terima";
                                                $result = $conn->query($sql);
                                                ?>

                                                <!-- Tampilkan pesan jika ada -->
                                                <?php if (isset($msg)) echo $msg; ?>

                                                <table class="table table-bordered">
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
                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $row['tanggal'] . "</td>";
                                                                echo "<td>" . $row['ruangan'] . "</td>";
                                                                echo "<td>" . $row['jenis'] . "</td>";
                                                                echo "<td>" . $row['jumlah'] . "</td>";
                                                                echo "<td>" . $row['keterangan'] . "</td>";
                                                                echo "<td><img src='" . $row['ttd'] . "' alt='Tanda Tangan'></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6'>Tidak ada data.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End of Main Content -->
                    </div>
                </div>

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>© 2024 Admin Syamrabu</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

    </div>
</body>

</html>
