<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "masterruangan");

    // Check the connection
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Get form data
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $ruangan = $_POST['ruangan'];
    $nama_aplikasi = $_POST['nama_aplikasi'];
    $kepada = $_POST['kepada'];
    $tanggal = $_POST['tanggal'];
    $topik = $_POST['topik'];
    $rincian = $_POST['rincian'];

    // Insert into database
    $sql = "INSERT INTO form_pengajuan (nama, nip, ruangan, nama_aplikasi, kepada, tanggal, topik, rincian) 
            VALUES ('$nama', '$nip', '$ruangan', '$nama_aplikasi', '$kepada', '$tanggal', '$topik', '$rincian')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }

    // Close connection
    $conn->close();
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

    <title>Form Pengajuan Data</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom CSS to remove border-radius -->
    <style>
        .form-control-no-radius {
            border-radius: 0 !important;
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Form Pengajuan Data</h1>
                                    </div>

                                    <!-- Form Pengajuan Data -->
                                    <form action="" method="POST" class="user">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control form-control-no-radius" id="nama" name="nama" placeholder="Masukkan Nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nip">NIP</label>
                                            <input type="text" class="form-control form-control-no-radius" id="nip" name="nip" placeholder="Masukkan NIP" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ruangan">Ruangan</label>
                                            <select class="form-control" id="ruangan" name="ruangan" required>
                                                <option value="" disabled selected></option>
                                                <?php
                                                    $conn = new mysqli("localhost", "root", "", "masterruangan");

                                                    if ($conn->connect_error) {
                                                        die("Koneksi gagal: " . $conn->connect_error);
                                                    }

                                                    $sql = "SELECT id, ruangan FROM master_ruangan";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<option value=\"" . $row["ruangan"] . "\">" . $row["ruangan"] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value=''>No data available</option>";
                                                    }

                                                    $conn->close();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="namaAplikasi">Nama Aplikasi</label>
                                            <input type="text" class="form-control form-control-no-radius" id="namaAplikasi" name="nama_aplikasi" placeholder="Masukkan Nama Aplikasi" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kepada">Ditujukan Kepada</label>
                                            <input type="text" class="form-control form-control-no-radius" id="kepada" name="kepada" placeholder="Ditujukan Kepada" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control form-control-no-radius" id="tanggal" name="tanggal" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="topik">Topik</label>
                                            <input type="text" class="form-control form-control-no-radius" id="topik" name="topik" placeholder="Masukkan Topik" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="rincian">Rincian</label>
                                            <textarea class="form-control form-control-no-radius" id="rincian" name="rincian" rows="4" placeholder="Masukkan Rincian" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Submit
                                        </button>
                                    </form>

                                    <!-- End of Form Pengajuan Data -->

                                </div>
                            </div>
                        </div>
                    </div>
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
