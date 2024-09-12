<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: tampilan.php");
    exit;
}
?>

<?php
$host = 'localhost';
$db = 'masterruangan';
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

// Mengambil data dari tabel 'priode' yang tanggal keluarnya null atau tidaka ada
$sql = "SELECT * FROM priode where tanggal_selesai is null";
$cektombol = $conn->query($sql)->fetch_assoc();
// print_r($cektombol);
?>
<?php
    $conn = new mysqli("localhost", "root", "", "masterruangan");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

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
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Periode</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <div class="sidebar-brand-text mx-3">INPUT DATA</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="tabel.php">
                <i class="fas fa-table"></i>
                <span>Data Periode</span>
            </a>
        </li>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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

                <!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Periode</h1>

    <?php
    if($cektombol == null){
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
            <a href="form_tabel.php?kembali=tabel.php" class="btn btn-danger">
                <i class=""></i> Back
            </a>
        </div>';
    }
    ?>
    
    <!-- Search Form -->
    <div class="mb-3">
        <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control" placeholder="Search data...">
    </div>

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
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Determine if the transaction is still open
            $isOpen = is_null($row['tanggal_selesai']);
            echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nama'] . "</td>
                <td>" . $row['tanggal_masuk'] . "</td>
                <td>" . ($isOpen ? 'Belum Selesai' : $row['tanggal_selesai']) . "</td>
                <td>
                    <a href='tabeldetail.php?id=" . $row['id'] . "' class='btn btn-info'><i class='fas fa-info-circle'></i> Detail</a>";
            
            if ($isOpen) {
                echo "
                    <form method='post' style='display:inline;' action=''>
                        <input type='hidden' name='transaction_id' value='" . $row['id'] . "'>
                        <button type='submit' class='btn btn-danger' name='tutup_transaksi'>Tutup Transaksi</button>
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


            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; ADMIN SYAMRABU 2024</span>
                    </div>
                </div>
            </footer>
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
