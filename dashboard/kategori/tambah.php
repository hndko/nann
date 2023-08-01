<?php
include_once('../../config/conn.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../");
}

if (isset($_POST['tambah_kategori'])) {
    $nama = $_POST['nama'];

    $sql_tambah_kategori = "INSERT INTO kategori (nama) VALUES ('$nama')";
    if (mysqli_query($conn, $sql_tambah_kategori)) {
        echo "<script type='text/javascript'>alert('Kategori berhasil ditambahkan');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error: " . $sql_tambah_kategori . "<br>" . mysqli_error($conn) . "');</script>";
    }
    header("Location: ./");
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

            <!-- Main Content -->
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
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tambah Kategori</h4>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">Kembali</button>
                        </div>
                        <div class="card-body">
                            <?php if ($_SESSION['access'] == 1) : ?>
                                <form method="POST">
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input name="nama" type="text" class="form-control mb-1" placeholder="Masukkan nama ...">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-1" name="tambah_kategori">Tambah</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once '../layout/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once '../layout/javascript.php' ?>

</body>

</html>