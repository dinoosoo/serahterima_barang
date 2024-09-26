<?php
session_start();

if(isset($_SESSION["login"])){
    if($_SESSION["role"] == "admin"){
        header("Location: admin.php");
    } elseif($_SESSION["role"] == "it"){
        header("Location: admin.php");
    } elseif($_SESSION["role"] == "kabag"){
        header("Location: admin.php");
    }
    exit;
}

require 'koneksi.php';

if( isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])){
            
            $_SESSION["login"] = true;
            $_SESSION["role"] = $row["role"];

            // Arahkan berdasarkan role
            if($row["role"] == "admin") {
                header("Location: admin.php");
            } elseif($row["role"] == "it") {
                header("Location: admin.php");
            } elseif($row["role"] == "kabag") {
                header("Location: admin.php");
            }
            exit;
        }
    }

    $error = true;

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

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .text-center {
            margin-bottom: 40px; /* Atur jarak di bawah teks "Welcome Back" */
        }

        .form-group {
            margin-bottom: 30px; /* Atur jarak antara input fields (username dan password) */
        }

        .btn-user {
            margin-top: 25px; /* Atur jarak di atas tombol login */
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
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <img src="img/syamrabu.jpg" alt="Login Image" 
                            style="width: 100%; height: auto; display: block; margin: 0 auto;
                            position: relative; top: 15%; border-radius: 10px; transform: translateX(40px);">
                        </div>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <label for="username" style="color: black;">Username</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username" aria-describedby="emailHelp"
                                                placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" style="color: black;">Password</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password">
                                        </div>
                                        <hr>
                                        <?php if( isset($error)) : ?>
                                            <p style="color: red; font-style: italic; font-size: 14px; align: center;">username atau password salah</p>
                                        <?php endif;?>
                                        <button type="submit" name="login" href="index.html" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
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