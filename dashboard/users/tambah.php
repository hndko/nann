<?php
require_once '../../config/conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../");
}

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $status = $_POST['status'];

    // echo $status;

    $sql = "INSERT INTO users (username, nama, alamat,telepon,email,password,status) VALUES ('$username', '$nama','$alamat','$telepon','$email','$password','$status')";
    if (mysqli_query($conn, $sql)) {
        echo "<script type='text/javascript'>alert('Pengguna berhasil ditambahkan');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
    }
    header("Location: ./");
}


if ($_SESSION['access'] == 3) {
    header("Location: ../../index.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../layout/head.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once '../layout/sidebar.php' ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome Back</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tambah User</h4>
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input name="nama" type="text" class="form-control mb-1" placeholder="Masukkan nama ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input name="username" type="text" class="form-control mb-1" placeholder="Masukkan username ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input name="password" type="password" class="form-control mb-1" placeholder="Masukkana password ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input name="email" type="text" class="form-control mb-1" placeholder="Masukkan email ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Telepon</label>
                                    <div class="col-sm-10">
                                        <input name="telepon" type="text" class="form-control mb-1" placeholder="Masukkan no telepon ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <input name="alamat" type="text" class="form-control mb-1" placeholder="Masukkan alamat ...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label go">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control mb-1" required>
                                            <option value="">Pilih Status</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Kepala Toko</option>
                                            <option value="3">Staff</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mb-1" name="tambah">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <?php require_once 'layout/footer.php' ?>
            <!-- End of Footer -->

        </div>
    </div>
    <!-- End of Page Wrapper -->

    <?php require_once '../layout/javascript.php' ?>

</body>

</html>