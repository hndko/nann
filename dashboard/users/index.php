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
                            <h4>List User</h4>
                            <a href="<?= $base_url ?>dashboard/users/tambah.php" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped border">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM users";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) :
                                    ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['telepon']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['alamat']; ?></td>
                                            <td><?php
                                                if ($row['status'] == 1) {
                                                    echo "Admin";
                                                } else if ($row['status'] == 2) {
                                                    echo "Kepala";
                                                } else if ($row['status'] == 3) {
                                                    echo "Staff";
                                                } else {
                                                    echo "Non-Aktif";
                                                }

                                                ?></td>
                                            <td>
                                                <a href="<?= $base_url ?>dashboard/users/edit_user.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">UBAH</a>
                                                <a href="<?= $base_url ?>dashboard/users/hapus_user.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">NON-AKTIF</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
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