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
    header("Location: dashboard");
}

include_once('../../assets/pdf/fpdf.php');

if (isset($_POST['download'])) {
    ob_end_clean();


    $pdf = new FPDF();

    //Add a new page
    $pdf->AddPage();
    $date = date('Y-m-d');

    // Set the font for the text
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(60, 10, 'SixTeen', 0, 1);
    $pdf->Cell(60, 10, 'Laporan Stok', 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Dicetak Pada: ' . $date, 0, 1);
    $pdf->Ln();

    $sql_kategori = "SELECT barang.id as id,barang.nama as nama, kategori.nama as kategori, stok FROM barang 
        JOIN kategori on kategori.id = barang.id_kategori";
    $result = mysqli_query($conn, $sql_kategori);
    $pdf->SetFont('Arial', '', 12);
    $header = array('Id', 'Barang', 'Kategori', 'Stok');
    $w = array(10, 100, 40, 25);
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    while ($row = mysqli_fetch_array($result)) {
        $pdf->Cell($w[0], 6, $row[0], 'LR');
        $pdf->Cell($w[1], 6, $row[1], 'LR');
        $pdf->Cell($w[2], 6, $row[2], 'LR', 0, 'L');
        $pdf->Cell($w[3], 6, $row[3], 'LR', 0, 'L');
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
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>List Kategori</h4>
                            <a href="<?= $base_url ?>dashboard/kategori/tambah.php" class="btn btn-primary btn-sm">Tambah Data</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped border">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kategori</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_kategori = "SELECT * FROM kategori";
                                    $result = mysqli_query($conn, $sql_kategori);
                                    while ($row = mysqli_fetch_array($result)) :
                                    ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['status'] == '1' ? 'Aktif' : 'Non-Akif' ?></td>
                                            <td>
                                                <?php if ($_SESSION['access'] == 1) : ?>
                                                    <a href="<?= $base_url ?>dashboard/kategori/edit_kategori.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">UBAH</a>
                                                    <?php if ($row['status'] == 1) : ?>
                                                        <a href="<?= $base_url ?>dashboard/kategori/hapus_kategori.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">NON-AKTIF</a>
                                                    <?php elseif ($row['status'] == 0) : ?>
                                                        <a href="<?= $base_url ?>dashboard/kategori/aktif_kategori.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">AKTIF</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
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