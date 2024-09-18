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

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="tabel.php">
    <div class="sidebar-brand-icon">
        <img src="img/rsud syamrabu.png" alt="" style="width: 80px; height: auto;">
    </div>
    <div class="sidebar-brand-text mx-3" style="margin-right: 70px;">SERVICE KATALOG<sup></sup></div>
</a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
        

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


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                     <!-- Content Wrapper -->
 <div class="content-wrapper">
      <!-- Content Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Detail</h1>
            </div>
          </div>
          <div class="d-flex justify-content-end mb-3">
            <a href="tabel.php" class="btn btn-danger">
                <i class=""></i> Back
            </a>
            <a href="kertas.php?id=<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>&jenis_berkas=<?php echo isset($_GET['jenis_berkas']) ? $_GET['jenis_berkas'] : ''; ?>" class="btn btn-primary">
            <i class=""></i> Print
            </a>
        </div>
        </div>
      </div>
                        <?php
                            // Koneksi ke database
                        $conn = new mysqli("localhost", "root", "", "masterruangan");

                        // Periksa koneksi
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        // Memeriksa apakah ID dan jenis_berkas ada di GET
                        if (isset($_GET['id']) && isset($_GET['jenis_berkas'])) {
                            $id = isset($_GET['id']) ? $_GET['id'] : null;
                            $jenis_berkas = $_GET['jenis_berkas']; // Hindari SQL Injection pada string
                            $no =1;
                            $sql = "SELECT * FROM form_serah_terima WHERE id_transaksi = '$id'  AND jenis_berkas = '$jenis_berkas'";
                            $result = $conn->query($sql);
                        } else {
                            echo "Pilih Jenis Berkas";
                        }
                        ?>

                      <div class="table-container">
                      <div class="form-group">
                        <form method="GET" action="tabeldetail.php">
                            <input type="hidden" name="id" value="<?php echo $id = $_GET['id']; ?>"> <!-- ID tetap dikirim -->
                            <input type="radio" id="barangBaru" name="jenis_berkas" value="Baru">
                            <label for="barangBaru">Barang Baru</label>
                            <input type="radio" id="barangRusak" name="jenis_berkas" value="Rusak">
                            <label for="barangRusak">Barang Rusak</label>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </form>
                    </div>

                    <div class="table-container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</td>
                                    <th>Tanggal</th>
                                    <th>Ruangan</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Tanda Tangan</th>
                                    <th>Aksi</th>
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
                                        echo "<td><a href='edit_form_tabel.php?id={$row['id']}&lokasi={$_GET['id']}' class='btn btn-primary mr-2'>Edit</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Tidak ada data.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MAGANG SYAMRABU  2024</span>
                    </div>
                    <div >
                        
                    </div>
                </div>
            </footer>

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
     <!-- Footer -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        function clearForm() {
            document.getElementById("main-form").reset();
            window.location.href = 'master jenis.php';
        }
    </script>
</body>

</html>

