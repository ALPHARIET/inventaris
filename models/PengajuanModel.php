<?php
class PengajuanModel {
    public static function create($id_prajurit, $id_barang, $jumlah) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO pengajuan (id_prajurit, id_barang, jumlah) VALUES (?,?,?)");
        $stmt->bind_param("iii", $id_prajurit, $id_barang, $jumlah);
        return $stmt->execute();
    }
    public static function getByPrajurit($id_prajurit) {
        global $conn;
        $stmt = $conn->prepare("SELECT p.*, b.nama_barang, b.satuan FROM pengajuan p JOIN barang b ON p.id_barang = b.id WHERE p.id_prajurit = ? ORDER BY p.tanggal_pengajuan DESC");
        $stmt->bind_param("i", $id_prajurit);
        $stmt->execute();
        return $stmt->get_result();
    }
    public static function getAntrean() {
        global $conn;
        return $conn->query("SELECT p.id, u.nama_lengkap AS pemohon, b.nama_barang, p.jumlah, p.tanggal_pengajuan 
                             FROM pengajuan p 
                             JOIN users u ON p.id_prajurit = u.id 
                             JOIN barang b ON p.id_barang = b.id 
                             WHERE p.status = 'menunggu' 
                             ORDER BY p.tanggal_pengajuan ASC");
    }
    public static function approve($id, $id_petugas) {
        global $conn;
        $stmt = $conn->prepare("UPDATE pengajuan SET status='disetujui', tanggal_disetujui=NOW(), id_petugas=? WHERE id=?");
        $stmt->bind_param("ii", $id_petugas, $id);
        return $stmt->execute();
    }
    public static function reject($id, $id_petugas) {
        global $conn;
        $stmt = $conn->prepare("UPDATE pengajuan SET status='ditolak', id_petugas=? WHERE id=?");
        $stmt->bind_param("ii", $id_petugas, $id);
        return $stmt->execute();
    }
}
?>