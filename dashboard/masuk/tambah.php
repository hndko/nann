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
    $barang = $_POST['barang'];
    $stok = $_POST['stok'];
    $expired = $_POST['expired'];
    $date = date('Y-m-d');
    $sql_tambah_transaksi = "INSERT INTO transaksi (tanggal,status) VALUES ('$date','1')";
    if (mysqli_query($conn, $sql_tambah_transaksi)) {
        $id_transaksi = mysqli_query($conn, "select count(1) FROM transaksi");
        $row = mysqli_fetch_array($id_transaksi);
        $total = $row[0];
        foreach ($barang as $key => $n) {
            $sql_tambah_detail_transaksi = "INSERT INTO detail_masuk (id,id_barang,stok,expired) VALUES ('$total','$n','$stok','$expired')";
            mysqli_query($conn, $sql_tambah_detail_transaksi);
            $sql_tambah_stok = "UPDATE `barang` SET `stok` = `stok`+$stok[$key] WHERE `barang`.`id` = '$n'";
            mysqli_query($conn, $sql_tambah_stok);
        }
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

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            Barang Masuk
                            <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">Kembali</button>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div id="item">
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-2 col-form-label">Pilih Barang</label>
                                        <div class="col-sm-10">
                                            <select name="barang[]" class="form-control mb-1">
                                                <?php
                                                $sql = "SELECT * FROM barang WHERE status='1'";
                                                $result = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value=<?php echo $row['id'] ?>><?php echo $row['nama']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-2 col-form-label">Stok</label>
                                        <div class="col-sm-10">
                                            <input name="stok[]" type="text" class="form-control mb-1" placeholder="Stok" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Expired</label>
                                    <div class="col-sm-10">
                                        <input name="expired[]" type="date" class="form-control mb-1" placeholder="date" required>
                                    </div>
                                </div>
                                <div class="btn btn-primary mb-1" id="tambah">Barang Lain</div>
                                <button type="submit" class="btn btn-primary mb-1" name="tambah">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    var index = 1;
                    $(document).ready(function() {
                        $('#tambah').click(function() {
                            $('#item').append($(`
                            <div id="item` + index + `">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Pilih Barang</label>
                                    <div class="col-sm-10">
                                        <select name="barang[]" class="form-control mb-1">
                                                <?php
                                                $sql = "SELECT * FROM barang WHERE status='1'";
                                                $result = mysqli_query($conn, $sql);

                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value=<?php echo $row['id'] ?>><?php echo $row['nama']; ?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Stok</label>
                                    <div class="col-sm-10">
                                        <input name="stok[]" type="text" class="form-control mb-1" placeholder="Stok" required>
                                    </div>
                                </div>
                            </div>        
                        `));
                        });
                    });
                </script>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once '../layout/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Laporan Pembelian</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="post" action="{{ route('reportPurchase') }}" autocomplete="off">
                    @csrf
                    <div class="modal-body">

                        <div class="form-floating">
                            <input type="date" class="form-control-plaintext" id="reportStart" name="reportStart" value="{{session('start')}}" required>
                            <label for="reportStart">Dari Tanggal:</label>
                        </div>


                        <div class="form-floating">
                            <input type="date" class="form-control-plaintext" id="reportEnd" name="reportEnd" value="{{session('end')}}" required>
                            <label for="reportEnd">Sampai Tanggal:</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                </form>

            </div>
        </div>
    </div>

    <?php require_once '../layout/javascript.php' ?>
    <script>
        let table = new DataTable('#myTable', {
            // options
        });
    </script>
</body>

</html>