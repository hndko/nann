<?php
require_once '../../config/conn.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../");
}
require('../../assets/pdf/fpdf.php');

if (isset($_POST['download'])) {
    ob_end_clean();


    $pdf = new FPDF();

    //Add a new page
    $pdf->AddPage();
    $date = date('Y-m-d');

    // Set the font for the text
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(60, 10, 'SixTeen', 0, 1);
    $pdf->Cell(60, 10, 'Laporan Barang Masuk', 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Dicetak Pada: ' . $date, 0, 1);
    $pdf->Ln();

    $id = $_GET['id'];
    $sql_kategori = "SELECT barang.id as id,barang.nama as nama, kategori.nama as kategori, detail_masuk.stok, detail_masuk.expired FROM detail_masuk 
        JOIN barang ON barang.id = detail_masuk.id_barang
        JOIN kategori ON barang.id_kategori = kategori.id
        WHERE detail_masuk.id='$id'";
    $result = mysqli_query($conn, $sql_kategori);
    $pdf->SetFont('Arial', '', 12);
    $header = array('Id', 'Barang', 'Kategori', 'Stok', 'Expired');
    $w = array(10, 80, 40, 25, 25);
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    while ($row = mysqli_fetch_array($result)) {
        $pdf->Cell($w[0], 6, $row[0], 'LR');
        $pdf->Cell($w[1], 6, $row[1], 'LR');
        $pdf->Cell($w[2], 6, $row[2], 'LR', 0, 'L');
        $pdf->Cell($w[3], 6, $row[3], 'LR', 0, 'L');
        $pdf->Cell($w[4], 6, $row[4], 'LR', 0, 'L');
        $pdf->Ln();
    }
    $pdf->Cell(array_sum($w), 0, '', 'T');

    // return the generated output
    $pdf->Output();
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
                        <div class="card-header">
                            Kode Barang Masuk BM<?= $_GET['id'] ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped border">
                                <thead>
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>Barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Expired</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id = $_GET['id'];
                                    $sql_kategori = "SELECT barang.id as id,barang.nama as nama, kategori.nama as kategori, detail_masuk.stok, detail_masuk.expired FROM detail_masuk JOIN barang ON barang.id = detail_masuk.id_barang JOIN kategori ON barang.id_kategori = kategori.id WHERE detail_masuk.id='$id';";
                                    $result = mysqli_query($conn, $sql_kategori);
                                    while ($row = mysqli_fetch_array($result)) :
                                    ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['kategori']; ?></td>
                                            <td><?= $row['stok']; ?></td>
                                            <td><?= $row['expired']; ?></td>

                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <form method="POST">
                                <button type="submit" name="download" class="btn btn-primary">Download</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once '../layout/javascript.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php require_once '../layout/javascript.php' ?>

</body>

</html>