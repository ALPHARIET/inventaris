<?php
require_once '../config/database.php';
if($_SESSION['role']!='petugas') die("Akses ditolak");
header("Location: ../views/laporan/rekap.php");
exit;
?>