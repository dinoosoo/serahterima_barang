<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: index.php");
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>MASTER</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="master ruangan.php">Master Ruangan</a>
                        <a class="collapse-item" href="master jenis.php">Master Jenis</a>
                        <!-- <a class="collapse-item" href="tampilan data.php">Tampilkan Data</a> -->
                        
                    </div>
                </div>
            </li>
            <li class="nav-item">

    <a class="nav-link" href="index.php">
    <a class="nav-link" href="tabel.php">
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
                    </li>
                </ul>
            </nav>


<!-- Nav Item - User Information -->
<!-- <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle fa-2x"></i> 
    </a> -->
    <!-- Dropdown - User Information -->
    <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div> -->
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
              <h1 class="m-0 text-dark">Master Jenis</h1>
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
                      <h3 class="card-title">Data Jenis</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-container">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Jenis</th>
                              <th colspan=2 class="centered-cell">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="jenis-table-body">
                            <!-- Data will be added here by PHP -->
                            <?php
                            // Koneksi ke database
                            $conn = new mysqli("localhost", "root", "", "masterruangan");

                            // Periksa koneksi
                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            // Ambil data dari tabel tjenis
                            $sql = "SELECT id, jenis FROM tjenis";
                            $result = $conn->query($sql);

                            // Loop melalui hasil dan buat baris tabel
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . $row["jenis"] . "</td>
                                    <td>
                                        <div class='d-flex justify-content-center'>
                                        <a href='master jenis.php?id={$row['id']}&edit=1' class='btn btn-primary mr-2'>Edit</a>
                                        <a href='masterjenis/hapus.php?id={$row['id']}' class='btn btn-danger'>Hapus</a>
                                        </div>
                                    </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No data</td></tr>";
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
                      <h3 class="card-title">Form Jenis</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            // Koneksi ke database
                            $conn = new mysqli("localhost", "root", "", "masterruangan");

                            // Periksa conn
                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            };
                            
                            $edit = isset($_GET['edit']) ? $_GET['edit'] : 0;
                            $row = array('id' => '', 'jenis' => '');
                            if ($edit) {
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM tjenis WHERE id=$id";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                }
                            }
                        ?>
                    <form id="main-form" method="post" action="<?php echo $edit == 0 ? 'masterjenis/tambah.php' : 'masterjenis/edit.php?id=' . htmlspecialchars($row['id']); ?>">
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" required
                            <?php echo $edit > 0 ? 'value="' . htmlspecialchars($row['jenis']) . '"' : 'placeholder=""'; ?>>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Tambah</button>
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

