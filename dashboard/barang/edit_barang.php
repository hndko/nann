<?php
require_once '../../config/conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../");
} else {
    $id_curr = $_SESSION['user'];
    $curr_user = "SELECT * FROM users WHERE id='$id_curr'";
    $result = mysqli_query($conn, $curr_user);
    if ($result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $keterangan = $_POST['keterangan'];

    $id = $_GET['id'];

    $sql = "UPDATE `barang` SET nama = '$nama', id_kategori = '$kategori', keterangan = '$keterangan' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script type='text/javascript'>alert('Barang berhasil diubah');</script>";
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

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Ubah Barang</h4>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">Kembali</button>
                        </div>
                        <div class="card-body">
                            <?php
                            $id_user = $_GET['id'];
                            $edit_user = "SELECT * FROM barang WHERE id='$id_user'";
                            $result = mysqli_query($conn, $edit_user);
                            if ($result->num_rows > 0) {
                                $edit_user = mysqli_fetch_assoc($result);
                            }
                            ?>
                            <form method="POST">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input name="nama" type="text" class="form-control mb-1" placeholder="Masukkan nama ..." value="<?= $edit_user['nama']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Stok</label>
                                    <div class="col-sm-10">
                                        <input name="Stok" type="text" class="form-control mb-1" placeholder="Alamat" value="<?= $edit_user['stok']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <select name="kategori" class="form-control mb-1">
                                            <?php
                                            $sql = "SELECT * FROM kategori WHERE status='1'";
                                            $result_kategori = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_array($result_kategori)) :
                                            ?>
                                                <option value="<?= $row['id'] ?>" <?= $row['id'] == $edit_user['id_kategori'] ? "selected" : ""; ?>><?= $row['nama']; ?></option>
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

                                <button type="submit" class="btn btn-primary mb-1" name="tambah">Ubah</button>
                            </form>
                        </div>
                    </div>
                </div>

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