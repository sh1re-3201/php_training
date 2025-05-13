<?php
require 'functions.php';

if (isset($_POST["submit_regis"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo "<script>
            alert('Username dan Password tidak boleh kosong!');
            </script>";
    } else if (registrasi($_POST) > 0) {

        echo "<script>
            alert('user berhasil registrasi');
            </script>";

        header("Location: Login.php");
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["login"])) {
    header("Location: Login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #a7c7e8;
        }

        .regis-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .footer-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="regis-container">
            <h2 class="mb-4 text-center">Halaman Registrasi</h2>

            <!-- Registration Form -->
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <div class="mb-3">
                    <label for="password2" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password2" id="password2" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="submit_regis" class="btn btn-primary">Register</button>
                </div>
            </form>

            <!-- Login Redirect -->
            <form action="" method="post" class="footer-link">
                <label class="me-2">Sudah punya akun?</label>
                <button type="submit" name="login" class="btn btn-outline-secondary btn-sm">Login Sekarang</button>
            </form>
        </div>
    </div>
</body>

</html>
