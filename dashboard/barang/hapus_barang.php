<?php
require_once '../../config/conn.php';
if ($_SESSION['access'] == 3) {
    header("Location: ../../index.php");
}
$id = $_GET['id'];
$sql_tambah_stok = "UPDATE `barang` SET `status` = '0' WHERE `barang`.`id` = $id";
mysqli_query($conn, $sql_tambah_stok);

header("Location: ./");
