<?php
require_once '../config/database.php';
require_once '../models/PengajuanModel.php';
require_once '../models/BarangModel.php';

$action = $_GET['action'] ?? '';

if ($action == 'buat') {
    if($_SESSION['role'] != 'prajurit') die("Akses ditolak");
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $id_prajurit = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("SELECT cek_stok(?, ?) AS cukup");
    $stmt->bind_param("ii", $id_barang, $jumlah);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if($res['cukup']) {
        PengajuanModel::create($id_prajurit, $id_barang, $jumlah);
        header("Location: ../views/pengajuan/daftar.php?success=1");
    } else {
        header("Location: ../views/pengajuan/buat.php?error=stok");
    }
    exit;
} elseif ($action == 'approve' && $_SESSION['role']=='petugas') {
    $id = $_GET['id'];
    $q = $conn->query("SELECT id_barang, jumlah FROM pengajuan WHERE id=$id");
    $data = $q->fetch_assoc();
    $stmt = $conn->prepare("SELECT cek_stok(?, ?) AS cukup");
    $stmt->bind_param("ii", $data['id_barang'], $data['jumlah']);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if($res['cukup']) {
        $conn->query("UPDATE barang SET stok = stok - {$data['jumlah']} WHERE id = {$data['id_barang']}");
        PengajuanModel::approve($id, $_SESSION['user_id']);
        header("Location: ../views/pengajuan/antrean.php?success=1");
    } else {
        header("Location: ../views/pengajuan/antrean.php?error=stok");
    }
    exit;
} elseif ($action == 'reject' && $_SESSION['role']=='petugas') {
    $id = $_GET['id'];
    PengajuanModel::reject($id, $_SESSION['user_id']);
    header("Location: ../views/pengajuan/antrean.php?success=2");
    exit;
}
?>