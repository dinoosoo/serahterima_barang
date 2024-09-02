<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
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
    <div class="sidebar-brand-text mx-3">SERVICE KATALOG<sup></sup></div>
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

            <!-- Heading -->
        

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>MASTER</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="master ruangan">Master Ruangan</a>
                        <a class="collapse-item" href="master jenis.php">Master Jenis</a>
                        <!-- <a class="collapse-item" href="tampilan data.php">Tampilkan Data</a> -->
                        
                    </div>
                </div>
            </li>
            <li class="nav-item">
    <a class="nav-link" href="tampilkan_data.php">
        <i class="fas fa-fw fa-table"></i>
        <span>SERAH TERIMA BARANG</span>
    </a>
</li>
            <!-- Nav Item - Utilities Collapse Menu -->
        

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
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                     
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
                    <h1 class="m-0 text-dark">Master Ruangan</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
  <div class="container-fluid">
    <div class="tab-content">
      <!-- Master Ruangan -->
      <div class="tab-pane fade show active" id="master-ruangan">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Ruangan</h3>
              </div>
              <div class="card-body">
                <div class="table-container">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Ruangan</th>
                        <th colspan=2 class="centered-cell">Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="ruangan-table-body">
                      <!-- Data will be added here by PHP -->
                      <?php
                      // Koneksi ke database
                      $conn = new mysqli("localhost", "root", "", "masterruangan");

                      // Periksa koneksi
                      if ($conn->connect_error) {
                          die("Koneksi gagal: " . $conn->connect_error);
                      }

                      // Ambil data dari tabel ruangan
                      $sql = "SELECT id, ruangan FROM ruangan";
                      $result = $conn->query($sql);

                      // Loop melalui hasil dan buat baris tabel
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>
                              <td>" . $row["id"] . "</td>
                              <td>" . $row["ruangan"] . "</td>
                              <td>
                                  <div class='d-flex justify-content-center'>
                                  <a href='master ruangan.php?id={$row['id']}&edit=1' class='btn btn-primary mr-2'>Edit</a>
                                  <a href='ruanganmaster/hapus.php?id={$row['id']}' class='btn btn-danger'>Hapus</a>
                                  </div>
                              </td>
                              </tr>";
                          }
                      } else {
                          echo "<tr><td colspan='3'>No data</td></tr>";
                      }

                      // Tutup koneksi
                      $conn->close();
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
                <h3 class="card-title">Form Ruangan</h3>
              </div>
              <div class="card-body">
                  <?php
                      // Koneksi ke database
                      $conn = new mysqli("localhost", "root", "", "masterruangan");

                      // Periksa koneksi
                      if ($conn->connect_error) {
                          die("Koneksi gagal: " . $conn->connect_error);
                      };

                      $edit = isset($_GET['edit']) ? $_GET['edit'] : 0;
                      $row = array('id' => '', 'ruangan' => '');
                      if ($edit) {
                          $id = $_GET['id'];
                          $sql = "SELECT * FROM ruangan WHERE id=$id";
                          $result = $conn->query($sql);
                          if ($result && $result->num_rows > 0) {
                              $row = $result->fetch_assoc();
                          }
                      }
                  ?>
              <form id="main-form" method="post" action="<?php echo $edit == 0 ? 'ruanganmaster/tambah.php' : 'ruanganmaster/edit.php?id=' . htmlspecialchars($row['id']); ?>">
              <div class="form-group">
                  <label for="ruangan">Ruangan</label>
                  <input type="text" class="form-control" id="ruangan" name="ruangan" value="<?php echo htmlspecialchars($row['ruangan']); ?>" required>
              </div>

                  <button type="submit" class="btn btn-primary btn-block"><?php echo $edit == 0 ? 'Tambah' : 'Update'; ?></button>
                  <button type="button" class="btn btn-danger btn-block" onclick="clearForm()">Bersihkan</button>
              </form>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>

    <!-- End of Page Wrapper -->
    <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; ADMIN SYAMRABU  2024</span>
                    </div>
                </div>
            </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
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
    <script>
        function clearForm() {
            document.getElementById("main-form").reset();
            window.location.href = 'master ruangan.php';
        }
    </script>

</body>

</html>