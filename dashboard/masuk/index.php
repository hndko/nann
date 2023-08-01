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
            $sql_tambah_detail_transaksi = "INSERT INTO detail_masuk (id,id_barang,stok,expired) VALUES ('$total','$n','$stok[$key]','$expired[$key]')";
            mysqli_query($conn, $sql_tambah_detail_transaksi);
            $sql_tambah_stok = "UPDATE `barang` SET `stok` = `stok`+$stok[$key] WHERE `barang`.`id` = '$n'";
            mysqli_query($conn, $sql_tambah_stok);
        }
    }
    header("Location: ./");
}

require('../../assets/pdf/fpdf.php');

if (isset($_POST['cetak'])) {

    ob_end_clean();
    $pdf = new FPDF();

    //Add a new page
    $pdf->AddPage();
    $date = date('Y-m-d');
    $start = $_POST['reportStart'];
    $end = $_POST['reportEnd'];

    // Set the font for the text
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(60, 10, 'SixTeen', 0, 1);
    $pdf->Cell(60, 10, 'Laporan Barang Masuk periode: ' . $start . " sampai " . $end, 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Dicetak Pada: ' . $date, 0, 1);
    $pdf->Ln();

    $sql_kategori = "SELECT * FROM transaksi WHERE status='1' AND
             tanggal BETWEEN '$start' AND '$end';";
    $result = mysqli_query($conn, $sql_kategori);
    $pdf->SetFont('Arial', '', 12);

    $header = array('Id', 'Tanggal');
    $w = array(50, 125);
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    while ($row = mysqli_fetch_array($result)) {
        $pdf->Cell($w[0], 6, "BM" . $row[0], 'LR');
        $pdf->Cell($w[1], 6, $row[1], 'LR');
        $pdf->Ln();
    }
    $pdf->Cell(array_sum($w), 0, '', 'T');

    // return the generated output
    $pdf->Output();
    header("Location: masuk.php");
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
                            List Barang Masuk
                            <a href="<?= $base_url ?>dashboard/masuk/tambah.php" class="btn btn-primary btn-sm">Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped border" id="myTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_kategori = "SELECT * FROM transaksi WHERE status='1'";
                                    $result = mysqli_query($conn, $sql_kategori);
                                    while ($row = mysqli_fetch_array($result)) :
                                    ?>
                                        <tr>
                                            <td>BM<?= $row['id'] ?></td>
                                            <td><?= $row['tanggal']; ?></td>
                                            <td>
                                                <a href="<?= $base_url ?>dashboard/masuk/detail_masuk.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">DETAIL</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            Cetak Laporan
                        </div>
                        <div class="card-body">
                            <form method="post" autocomplete="off">
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Dari Tanggal:</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="reportStart" name="reportStart" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-2 col-form-label">Sampai Tanggal:</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="reportStart" name="reportEnd" required></label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name="cetak">Cetak Laporan</button>
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
                                <select name="barang[]" class="form-select mt-3">
                                    <?php
                                    $sql = "SELECT * FROM barang WHERE status='1'";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value=<?= $row['id'] ?>><?= $row['nama']; ?></option>
                                        <?php
                                    }
                                        ?>
                                </select>
                                
                                <input name="stok[]" type="text" class="form-control mb-1" placeholder="Stok">
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