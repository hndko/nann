<?php
include_once('../../config/conn.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../");
}

if (isset($_POST['tambah_barang'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $keterangan = $_POST['keterangan'];

    $sql_tambah_barang = "INSERT INTO barang (nama,id_kategori,keterangan) VALUES ('$nama','$kategori','$keterangan')";
    if (mysqli_query($conn, $sql_tambah_barang)) {
        echo "<script type='text/javascript'>alert('Barang berhasil ditambahkan');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error: " . $sql_tambah_barang . "<br>" . mysqli_error($conn) . "');</script>";
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
                            <h4>Tambah Barang</h4>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">Kembali</button>
                        </div>
                        <div class="card-body">
                            <?php if ($_SESSION['access'] == 1) : ?>
                                <form action="" method="POST">
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input name="nama" type="text" class="form-control mb-1" placeholder="Masukkan nama ..." required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                        <div class="col-sm-10">
                                            <select name="kategori" class="form-control mb-1" required>
                                                <?php
                                                $sql = "SELECT * FROM kategori WHERE status='1'";
                                                $result = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_array($result)) :
                                                ?>
                                                    <option value=<?= $row['id'] ?>><?= $row['nama']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" required></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-1" name="tambah_barang">Tambah</button>
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