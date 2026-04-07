<?php
require_once '../config/database.php';
require_once '../models/PengembalianModel.php';

$action = $_GET['action'] ?? '';

if ($action == 'buat' && $_SESSION['role']=='prajurit') {
    $id_pengajuan = $_POST['id_pengajuan'];
    $jumlah_kembali = $_POST['jumlah_kembali'];
    $kondisi = $_POST['kondisi'];
    $catatan = $_POST['catatan'];
    $id_prajurit = $_SESSION['user_id'];
    $q = $conn->query("SELECT id_barang FROM pengajuan WHERE id=$id_pengajuan");
    $row = $q->fetch_assoc();
    $id_barang = $row['id_barang'];
    PengembalianModel::create($id_pengajuan, $id_prajurit, $id_barang, $jumlah_kembali, $kondisi, $catatan);
    header("Location: ../views/pengembalian/riwayat.php?success=1");
    exit;
} elseif ($action == 'terima' && $_SESSION['role']=='petugas') {
    $id = $_GET['id'];
    PengembalianModel::terima($id);
    header("Location: ../views/pengembalian/verifikasi.php?success=1");
    exit;
}
?>