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

    $id = $_GET['id'];

    $sql = "UPDATE `kategori` SET nama = '$nama' WHERE id = $id";
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
                            Ubah Kategori
                            <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">Kembali</button>
                        </div>
                        <div class="card-body">
                            <?php
                            $id_user = $_GET['id'];
                            $edit_user = "SELECT * FROM kategori WHERE id='$id_user'";
                            $result = mysqli_query($conn, $edit_user);
                            if ($result->num_rows > 0) {
                                $edit_user = mysqli_fetch_assoc($result);
                            }
                            ?>
                            <form method="POST">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input name="nama" type="text" class="form-control mb-1" placeholder="Nama" value="<?php echo $edit_user['nama']; ?>">
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