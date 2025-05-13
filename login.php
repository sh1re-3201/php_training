<?php

session_start();


if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username_check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($username_check) === 1) {
        // echo"<p>username cool</p>";

        $row = mysqli_fetch_assoc($username_check);


        if (password_verify($password, $row["PASSWORD"])) {
            // session set
            $_SESSION["login"] = true;
            $_SESSION["uid"] = $row["UID"];


            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}
if (isset($_POST["register"])) {
    header("Location: regis.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #A7C7E7;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-text-error {
            color: red;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Selamat Datang!</h2>
            <h4 class="text-center mb-4">Login</h4>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    Username atau password salah!
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </div>

                
            </form>
            <form action="" method="post">
                <div class="text-center mt-3">
                    <label for="register">Belum memiliki akun?</label>
                    <div class="d-grid mt-2">
                        <button type="submit" name="register" class="btn btn-outline-secondary">Register Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
