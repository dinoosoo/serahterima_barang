<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
// Pastikan pengguna adalah admin
if($_SESSION["role"] != "admin" && $_SESSION["role"] != "it"){
    header("Location: admin.php"); // Arahkan ke halaman yang menunjukkan akses tidak diizinkan
    exit;
}
// Simpan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $ruangan = $_POST['ruangan'];
    $nama_aplikasi = $_POST['nama_aplikasi'];
    $kepada = $_POST['kepada'];
    $tanggal = $_POST['tanggal'];
    $topik = $_POST['topik'];
    $rincian = $_POST['rincian'];
    $signature = $_POST['signature'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "masterruangan");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menyimpan data (tanpa status)
    $sql = "INSERT INTO data_pengajuan (nama, nip, ruangan, nama_aplikasi, kepada, tanggal, topik, rincian, signature)
            VALUES ('$nama', '$nip', '$ruangan', '$nama_aplikasi', '$kepada', '$tanggal', '$topik', '$rincian', '$signature')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan!";
    } 
    // Perbarui status menjadi 'Sudah Terbuka'
    $sql = "UPDATE data_pengajuan SET status='Sudah Terbuka' WHERE id='$id' AND status='Belum Terbuka'";

    if ($conn->query($sql) === TRUE) {
        echo "Status berhasil diperbarui menjadi 'Sudah Terbuka'";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}



?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ADMIN SYAMRABU</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="img/rsud syamrabu.png" alt="" style="width: 80px; height: auto;">
                </div>
                <div class="sidebar-brand-text mx-3" style="margin-right: 70px;">SERVICE KATALOG</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Master Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
                    aria-expanded="true" aria-controls="collapseMaster">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>MASTER</span>
                </a>
                <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="master_ruangan.php">Master Ruangan</a>
                        <a class="collapse-item" href="master_jenis.php">Master Jenis</a>
                        <a class="collapse-item" href="master_aplikasi.php">Master Aplikasi</a>
                        <a class="collapse-item" href="master_topik.php">Master Topik</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tampilkan Data -->
            <li class="nav-item">
                <a class="nav-link" href="tabel.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>SERAH TERIMA BARANG</span>
                </a>
            </li>
<!-- Nav Item - Tampilkan Data -->
<li class="nav-item">
    <a class="nav-link" href="serah_pengajuan.php">
        <i class="fas fa-fw fa-file-alt"></i> <!-- Ganti dengan ikon yang sesuai -->
        <span>SERAH PENGAJUAN</span>
    </a>
</li>


            <hr class="sidebar-divider d-none d-md-block">


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
            <!-- Your content here -->
        <!-- End of Main Content -->


        <!-- End of Content Wrapper -->

        <!-- End of Page Wrapper -->
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div class="mb-3">
                    <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Search data...">
                </div>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Topbar Links -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                                                <!-- Nav Item - User Information -->
                                                <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle fa-2x"></i> 
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
</li>

                </ul>
            </nav>

</li>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Search Form - pindah ke atas data barang -->
                <!-- <div class="mb-3">
                    <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Search data...">
                </div> -->

                <!-- Heading Data Barang -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark" style="margin-bottom: 40px;">Data Serah Pengajuan</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="dataTable">
    <thead>
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "masterruangan");

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mengambil data dari tabel data_pengajuan
        $sql = "SELECT id, rincian, status FROM form_pengajuan";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $no = 1; // Inisialisasi nomor urut
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $row['rincian'] . "</td>";
                echo "<td>" . $row['status'] . "</td>"; // Tampilkan status
                echo "<td>
                        <a href='kertas_pengajuan.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Buka</a>
                        <button class='btn btn-danger btn-sm'>Delete</button>
                      </td>";
                echo "</tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
        }
        

        $conn->close();
        ?>
    </tbody>
</table>
    </div>
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
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin keluar dari halaman ini? 
                    Pastikan untuk menyimpan semua pekerjaan Anda sebelum melanjutkan.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
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

</body>
</html>
