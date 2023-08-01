<?php
require_once '../../config/conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../");
}

if (isset($_POST['tambah'])) {
    $barang = $_POST['barang'];
    $stok = $_POST['stok'];
    $date = date('Y-m-d');
    $tersedia = true;
    foreach ($barang as $key => $n) {
        $stock = "SELECT nama, stok FROM `barang` WHERE `barang`.`id` = '$n'";
        $result = mysqli_query($conn, $stock);
        $result = mysqli_fetch_assoc($result);

        if ($result['stok'] < $stok[$key]) {
            $tersedia = false;
            echo "<script type='text/javascript'>alert('Stock barang " . $result['nama'] . " tidak mencukupi');</script>";
        }
    }
    if ($tersedia == true) {
        $sql_tambah_transaksi = "INSERT INTO transaksi (tanggal,status) VALUES ('$date','2')";
        if (mysqli_query($conn, $sql_tambah_transaksi)) {
            $id_transaksi = mysqli_query($conn, "select count(1) FROM transaksi");
            $row = mysqli_fetch_array($id_transaksi);
            $total = $row[0];
            foreach ($barang as $key => $n) {
                $sql_tambah_detail_transaksi = "INSERT INTO detail_keluar (id,id_barang,stok) VALUES ('$total','$n','$stok[$key]')";
                mysqli_query($conn, $sql_tambah_detail_transaksi);
                $sql_tambah_stok = "UPDATE `barang` SET `stok` = `stok`-$stok[$key] WHERE `barang`.`id` = '$n'";
                mysqli_query($conn, $sql_tambah_stok);
            }
        }
        header("Location: ./");
    }
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
    $pdf->Cell(60, 10, 'Laporan Barang Keluar periode: ' . $start . " sampai " . $end, 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Dicetak Pada: ' . $date, 0, 1);
    $pdf->Ln();

    $sql_kategori = "SELECT * FROM transaksi WHERE status='2' AND
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
                            List Barang Keluar
                            <a href="<?= $base_url ?>dashboard/keluar/tambah.php" class="btn btn-primary btn-sm">Tambah Data</a>
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
                                    $sql_kategori = "SELECT * FROM transaksi WHERE status='2'";
                                    $result = mysqli_query($conn, $sql_kategori);
                                    while ($row = mysqli_fetch_array($result)) :
                                    ?>
                                        <tr>
                                            <td>BM<?php echo $row['id'] ?></td>
                                            <td><?php echo $row['tanggal']; ?></td>
                                            <td>
                                                <a href="<?= $base_url ?>dashboard/keluar/detail_keluar.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">DETAIL</a>
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
    <script>
        let table = new DataTable('#myTable', {
            // options
        });
    </script>
</body>

</html>