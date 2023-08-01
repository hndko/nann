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

    // Set the font for the text
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(60, 10, 'SixTeen', 0, 1);
    $pdf->Cell(60, 10, 'Laporan Barang Keluar', 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Dicetak Pada: ' . $date, 0, 1);
    $pdf->Ln();

    $id = $_GET['id'];
    $sql_kategori = "SELECT barang.id as id,barang.nama as nama, kategori.nama as kategori, detail_keluar.stok FROM detail_keluar JOIN barang ON barang.id = detail_keluar.id_barang JOIN kategori ON barang.id_kategori = kategori.id WHERE detail_keluar.id='$id'";
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
                            Kode Barang Keluar BK<?php echo $_GET['id'] ?>
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
                                    $sql_kategori = "SELECT barang.id as id,barang.nama as nama, kategori.nama as kategori, detail_keluar.stok, detail_keluar.expired FROM detail_keluar JOIN barang ON barang.id = detail_keluar.id_barang JOIN kategori ON barang.id_kategori = kategori.id WHERE detail_keluar.id='$id'";
                                    $result = mysqli_query($conn, $sql_kategori);
                                    while ($row = mysqli_fetch_array($result)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['kategori']; ?></td>
                                            <td><?php echo $row['stok']; ?></td>
                                            <td><?php echo $row['expired']; ?></td>

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
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SixTeen</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>