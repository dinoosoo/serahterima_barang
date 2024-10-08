<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
// Pastikan pengguna adalah admin
if($_SESSION["role"] == "kabag"){
    header("Location: admin.php"); // Arahkan ke halaman yang menunjukkan akses tidak diizinkan
    exit;
}
$host = 'localhost';
$db = 'magang_syamrabu';
$user = 'root';
$pass = '';

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data dari tabel 'priode'
$sql = "SELECT * FROM priode";
$result = $conn->query($sql);

// Mengambil data dari tabel 'priode' yang tanggal keluarnya null atau tidak ada
$sql = "SELECT * FROM priode WHERE tanggal_selesai IS NULL";
$cektombol = $conn->query($sql)->fetch_assoc();

// Jika tombol 'Tutup Transaksi' ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tutup_transaksi'])) {
    // Query untuk meng-update kolom `tanggal_selesai` pada baris yang masih null
    $sql = "UPDATE priode SET tanggal_selesai = NOW() WHERE tanggal_selesai IS NULL";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-success'>Transaksi berhasil ditutup.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
$conn->close();
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

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if ($_SESSION["role"] == "admin") :?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>MASTER</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="master_ruangan.php">Master Ruangan</a>
                        <a class="collapse-item" href="master_jenis.php">Master Jenis</a>
                        <a class="collapse-item" href="master_aplikasi.php">Master Aplikasi</a>
                        <a class="collapse-item" href="master_topik.php">Master Topik</a>
                        <!-- <a class="collapse-item" href="tampilan data.php">Tampilkan Data</a> -->  
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <hr class="sidebar-divider">
            <?php endif; ?>

<?php if ($_SESSION["role"] != "kabag" ) :?>
<!-- Nav Item - Tampilkan Data -->
<li class="nav-item">
    <a class="nav-link" href="tabel.php">
        <i class="fas fa-fw fa-table"></i>
        <span>SERAH TERIMA BARANG</span>
    </a>
</li>
<?php endif; ?>
<!-- Nav Item - Tampilkan Data -->
<li class="nav-item">
    <a class="nav-link" href="serah_pengajuan.php">
        <i class="fas fa-fw fa-file-alt"></i> <!-- Ganti dengan ikon yang sesuai -->
        <span>FORM PENGAJUAN</span>
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
              <h1 class="m-0 text-dark">Data Barang</h1>
            </div>
          </div>
        </div>
      </div>

                <?php
                if ($cektombol == null) {
                    echo '
                    <!-- Button New -->
                    <div class="d-flex justify-content-end mb-3">
                        <a href="periode.php" class="btn btn-success">
                            <i class="fas fa-plus"></i> New
                        </a>
                    </div>';
                } else {
                    echo '
                    <div class="d-flex justify-content-end mb-3">
                        <a href="form_tabel.php?kembali=tabel.php" class="btn btn-success">
                            <i class="fas fa-plus"></i> Insert
                        </a>
                    </div>';
                }
                ?>

                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Periode</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Initialize counter variable
                        $no = 1;

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Determine if the transaction is still open
                                $isOpen = is_null($row['tanggal_selesai']);
                                echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td>" . $row['nama'] . "</td>
                                    <td>" . $row['tanggal_masuk'] . "</td>
                                    <td>" . ($isOpen ? 'Belum Selesai' : $row['tanggal_selesai']) . "</td>
                                    <td>
                                        <a href='tabeldetail.php?id=" . $row['id'] . "&status=" . $isOpen . "&jenis_berkas=Baru' class='btn btn-info'><i class='fas fa-info-circle'></i> Detail</a>";

                                        if ($isOpen) {
                                            echo "
                                                <form method='post' style='display:inline;' action=''>
                                                    <input type='hidden' name='transaction_id' value='" . $row['id'] . "'>
                                                    <button type='submit' class='btn btn-danger' name='tutup_transaksi'
                                                        onclick=\"return confirm('Apakah Anda yakin akan menutup transaksi ini?');\"><i class='fas fa-lock'></i>
                                                        Closed
                                                    </button>
                                                </form>";
                                        }

                                echo "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script>
            function searchTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchInput");
                filter = input.value.toLowerCase();
                table = document.getElementById("dataTable");
                tr = table.getElementsByTagName("tr");

                for (i = 1; i < tr.length; i++) { // Skip the header row
                    tr[i].style.display = "none";
                    td = tr[i].getElementsByTagName("td");
                    for (var j = 0; j < td.length; j++) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                break;
                            }
                        }
                    }
                }
            }
            </script>
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
    </div>
</div>

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
