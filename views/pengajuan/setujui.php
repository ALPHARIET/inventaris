<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
if(!isPetugas()) die("Akses ditolak");

$id = $_GET['id'];
$action = $_GET['action'];

// Ambil detail pengajuan
$q = $conn->query("SELECT id_barang, jumlah FROM pengajuan WHERE id=$id");
$data = $q->fetch_assoc();

if($action == 'approve') {
    // Panggil function cek_stok dari database
    $stmt = $conn->prepare("SELECT cek_stok(?, ?) AS cukup");
    $stmt->bind_param("ii", $data['id_barang'], $data['jumlah']);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if($res['cukup']) {
        // Kurangi stok barang
        $conn->query("UPDATE barang SET stok = stok - {$data['jumlah']} WHERE id = {$data['id_barang']}");
        // Update status pengajuan
        $conn->query("UPDATE pengajuan SET status='disetujui', tanggal_disetujui=NOW(), id_petugas={$_SESSION['user_id']} WHERE id=$id");
        echo "<script>alert('Pengajuan disetujui, stok berkurang'); window.location='antrean.php';</script>";
    } else {
        echo "<script>alert('Stok tidak mencukupi!'); window.location='antrean.php';</script>";
    }
} elseif($action == 'reject') {
    $conn->query("UPDATE pengajuan SET status='ditolak' WHERE id=$id");
    echo "<script>alert('Pengajuan ditolak'); window.location='antrean.php';</script>";
}
?>