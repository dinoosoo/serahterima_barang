<?php
session_start();
$id = $_GET['id'];
$status = $_GET['status'];
$jenis_berkas = $_GET['jenis_berkas']; // Hindari SQL Injection pada string
    // Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT fs.id, fs.tanggal, mr.ruangan, mj.jenis, fs.jumlah, fs.keterangan, fs.ttd 
    FROM form_serah_terima fs
    JOIN master_ruangan mr ON fs.ruangan = mr.id
    JOIN master_jenis mj ON fs.jenis = mj.id
    WHERE id_transaksi = '$id'  AND jenis_berkas = '$jenis_berkas'";
$no =1;
$result = $conn->query($sql);

// Memeriksa apakah ID dan jenis_berkas ada di GET
if (isset($_POST['tampil'])) {
    $jenis_berkas = isset($_POST['jenis_berkas']) && !empty($_POST['jenis_berkas']) ? $_POST['jenis_berkas'] : 'Baru';

    $sql = "SELECT fs.id, fs.tanggal, mr.ruangan, mj.jenis, fs.jumlah, fs.keterangan, fs.ttd 
        FROM form_serah_terima fs
        JOIN master_ruangan mr ON fs.ruangan = mr.id
        JOIN master_jenis mj ON fs.jenis = mj.id
        WHERE id_transaksi = '$id'  AND jenis_berkas = '$jenis_berkas'";
    $no =1;
    $result = $conn->query($sql);
}
// Query untuk mengambil data dari form_serah_terima dengan join ke master_ruangan dan master_jenis

$sql = "SELECT * FROM priode WHERE tanggal_selesai IS NULL AND id=$id";
$cektombol = $conn->query($sql)->fetch_assoc();

?>
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Merek -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" class="nav-link" href="index.php">
    <div class="sidebar-brand-icon">
        <img src="img/rsud syamrabu.png" alt="" style="width: 80px; height: auto;">
    </div>
    <div class="sidebar-brand-text mx-3" style="margin-right: 70px;">SERVICE KATALOG<sup></sup></div>
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

            <!-- Heading -->
        

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
        <i class="fas fa-user-circle fa-2x"></i> <!-- Ganti gambar dengan ikon kepala polos -->
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
      <!-- Tombol Back -->
      <a href="tabel.php" class="btn btn-danger me-2">
        <i class="fas fa-arrow-left"></i> Back
      </a>
      
      <!-- Tombol Plus -->
      <?php if ($cektombol != null) : ?>
      <a href="form_tabel.php?kembali=tabel.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Insert
      </a>
       <?php endif; ?>
      <!-- Tombol Print -->
      <a href="kertas.php?id=<?php echo $id; ?>&status=<?php echo $status; ?>&jenis_berkas=<?php echo $jenis_berkas; ?>" class="btn btn-primary ms-2">
        <i class="fas fa-print"></i> Print
      </a>
    </div>
  </div>
</div>

<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "masterruangan");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil status dan ID dari URL
$status = isset($_GET['status']) ? $_GET['status'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Query untuk mengambil data dari form_serah_terima dengan join ke master_ruangan dan master_jenis
$sql = "SELECT fs.id, fs.tanggal, mr.ruangan, mj.jenis, fs.jumlah, fs.keterangan, fs.ttd 
        FROM form_serah_terima fs
        JOIN master_ruangan mr ON fs.ruangan = mr.id
        JOIN master_jenis mj ON fs.jenis = mj.id";


$result = $conn->query($sql);
?>

<div class="table-container">
    <div class="form-group">
        <form method="GET" action="tabeldetail.php">
            <!-- Validasi jika $_GET['status'] ada -->
            <input type="hidden" name="status" value="<?php echo isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ''; ?>">
            <!-- Validasi jika $_GET['id'] ada -->
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>"> <!-- ID tetap dikirim -->
            
            <input type="radio" id="barangBaru" name="jenis_berkas" value="Baru">
            <label for="barangBaru">Barang Baru</label>
            
            <input type="radio" id="barangRusak" name="jenis_berkas" value="Rusak">
            <label for="barangRusak">Barang Rusak</label>
            
            <button type="submit" class="btn btn-primary">Show</button>
        </form>
    </div>
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
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['tanggal'] . "</td>";
                            echo "<td>" . $row['ruangan'] . "</td>"; // Nama ruangan dari master_ruangan
                            echo "<td>" . $row['jenis'] . "</td>";   // Nama jenis dari master_jenis
                            echo "<td>" . $row['jumlah'] . "</td>";
                            echo "<td>" . $row['keterangan'] . "</td>";
                            echo "<td><img src='" . $row['ttd'] . "' alt='Tanda Tangan' width='100'></td>";
                            if ($status) {
                                echo "<td><a href='edit_form_tabel.php?id={$row['id']}&lokasi={$id}' class='btn btn-primary mr-2'>Edit</a></td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align: center;'>Tidak ada data.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
            <!-- End of Footer -->

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
    <div>
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
    <!-- End of Page Wrapper -->
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

