<?php
require 'functions.php';

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();;
}

if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}

// echo"<h1> Willkomen!! <h1>";

$uid = $_SESSION["uid"];
$result = mysqli_query($conn, "SELECT * FROM todo_entries WHERE UID = '$uid'");


if (isset($_POST["add"])) {
    $entry = $_POST["entry"];
    $uid = $_SESSION['uid'];

    mysqli_query($conn, "INSERT INTO `todo_entries` (`ENTRY_ID`, `ENTRY`, `STATUS`, `UID`, `DATE_ENTERED`) VALUES ('', '$entry', '', '$uid', current_timestamp());");
    header("Location: index.php");
    exit();
}
if (isset($_POST['mark_done'])) {
    $entry_id = $_POST['id'];
    $uid = $_SESSION['uid'];

    // Make sure the user only updates their own entries
    mysqli_query($conn, "UPDATE todo_entries SET STATUS = 1 WHERE ENTRY_ID = '$entry_id' AND UID = '$uid'");

    header("Location: index.php");
    exit();
}

if (isset($_POST["delete"])) {
    $entry_id = $_POST["id"];
    $uid = $_SESSION["uid"];

    mysqli_query($conn, "DELETE FROM todo_entries WHERE ENTRY_ID = '$entry_id' AND UID = '$uid' ");
    header("Location: index.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #A7C7E7;
        }

        .todo-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .todo-text.done {
            text-decoration: line-through;
            color: gray;
        }

        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .todo-input {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .todo-actions form {
            display: inline-block;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .foto-profil {
            align-items: center;
            border: 1px solid black;
            background-color: rgba(133, 136, 133, 1);
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="post" class="logout-btn">
            <button type="submit" name="logout" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>

        <div class="todo-container d-flex flex-column align-items-center text-center">
            <img src="/img/default-profile-picture-male-icon.png" width="250" class="rounded-circle foto-profil">
            <h2 class="text-center">Anugrah Frumensius Gansalangi</h2>
            <h4 class="text-center mb-3">235314091</h4>

            <h2 class="text-center mb-4">To-Do List</h2>

            <form action="" method="post" class="todo-input">
                <input type="text" name="entry" placeholder="Teks to do" class="form-control" required>
                <button type="submit" name="add" class="btn btn-primary">Tambah</button>
            </form>

            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="todo-item">
                    <div class="todo-text <?= $row['STATUS'] == 1 ? 'done' : '' ?>">
                        <?= htmlspecialchars($row["ENTRY"]); ?>
                        <div class="text-muted small ms-md-3 mt-2 mt-md-0 text-end" style="min-width: 120px;">
                            <small class="text-muted">Date Added: <?= date("Y-m-d", strtotime($row["DATE_ENTERED"])); ?></small>
                        </div>


                    </div>
                    <div class="todo-actions ms-md-5">
                        <?php if ($row['STATUS'] != 1): ?>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?= $row['ENTRY_ID'] ?>">
                                <button type="submit" name="mark_done" class="btn btn-success btn-sm">Selesai</button>
                            </form>
                        <?php endif; ?>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= $row['ENTRY_ID'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>