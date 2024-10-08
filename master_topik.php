<?php
session_start();
require 'koneksi.php';
if(!isset($_SESSION["login"])){
    header("Location: tampilan.php");
    exit;
}
// Pastikan pengguna adalah admin
if($_SESSION["role"] != "admin" && $_SESSION["role"] != "it"){
    header("Location: admin.php"); // Arahkan ke halaman yang menunjukkan akses tidak diizinkan
    exit;
}
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
    <style>
        .centered-cell {
            text-align: center;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"class="nav-link" href="admin.php">
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
              <h1 class="m-0 text-dark">Master Topik</h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="tab-content">
            <!-- Master Ruangan -->
            <div class="tab-pane fade show active" id="master-jenis">
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Data Topik</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-container">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>NO</th>
                              <th>Topik</th>
                              <th colspan=2 class="centered-cell">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="jenis-table-body">
                            <!-- Data will be added here by PHP -->
                            <?php
                            // Ambil data dari tabel tjenis
                            $sql = "SELECT * FROM master_topik";
                            $result = $conn->query($sql);

                            // Loop melalui hasil dan buat baris tabel
                            if ($result->num_rows > 0) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                    <td>" . $no ++ . "</td>
                                    <td>" . $row["topik"] . "</td>
                                    <td>
                                        <div class='d-flex justify-content-center'>
                                        <a href='master_topik.php?id={$row['id']}&edit=1' class='btn btn-primary mr-2'>Change</a>";
                                    if ($row['nonaktif']==0){
                                        echo "<a href='crud/hapus.php?id={$row['id']}&tabel=master_topik&master=master_topik.php' class='btn btn-success'>Restore</a>";
                                    } else {
                                        echo "<a href='crud/hapus.php?id={$row['id']}&tabel=master_topik&master=master_topik.php' class='btn btn-danger'>Remove</a>";
                                    }
                                    echo "</div>
                                    </td>
                                    </tr>";
                               }
                      } else {
                        echo "<tr><td colspan='3' style='text-align: center;'>No data</td></tr>";

                      }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Form Topik</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            $edit = isset($_GET['edit']) ? $_GET['edit'] : 0;
                            $row = array('id' => '', 'topik' => '');
                            if ($edit) {
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM master_topik WHERE id=$id";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                }
                            }
                        ?>
                    <form id="main-form" method="post" action="<?php echo $edit == 0 ? 'crud/tambah.php?tabel=master_topik&kolom=topik&master=master_topik.php' : 'crud/edit.php?id=' . htmlspecialchars($row['id']) . '&tabel=master_topik&kolom=topik&master=master_topik.php'; ?>">

                        <div class="form-group">
                            <label for="topik">Topik</label>
                            <input type="text" class="form-control" id="topik" name="isi" required
                            <?php echo $edit > 0 ? 'value="' . htmlspecialchars($row['topik']) . '"' : 'placeholder=""'; ?>>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><?php echo $edit == 0 ? 'Add' : 'Update'; ?></button>
                        <button type="button" class="btn btn-danger btn-block" onclick="clearForm()">Clean Up</button>
                    </form>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MAGANG SYAMRABU  2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    
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
            window.location.href = 'master_topik.php';
        }
    </script>
</body>

</html>

