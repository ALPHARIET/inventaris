<?php
class PengembalianModel {
    public static function create($id_pengajuan, $id_prajurit, $id_barang, $jumlah_kembali, $kondisi, $catatan) {
        global $conn;
        
        // Validasi dan bersihkan nilai kondisi (pastikan sesuai ENUM)
        $valid_kondisi = ['Baik', 'Rusak', 'Hilang'];
        $kondisi_clean = ucfirst(strtolower(trim($kondisi)));
        if (!in_array($kondisi_clean, $valid_kondisi)) {
            $kondisi_clean = 'Baik'; // default
        }
        
        $stmt = $conn->prepare("INSERT INTO pengembalian (id_pengajuan, id_prajurit, id_barang, jumlah_kembali, kondisi, catatan, status) VALUES (?,?,?,?,?,?,'diajukan')");
        // PERBAIKAN: gunakan "iiiiss" (4 integer, 2 string)
        $stmt->bind_param("iiiiss", $id_pengajuan, $id_prajurit, $id_barang, $jumlah_kembali, $kondisi_clean, $catatan);
        return $stmt->execute();
    }
    
    public static function getByPrajurit($id_prajurit) {
        global $conn;
        $stmt = $conn->prepare("SELECT p.*, b.nama_barang, pj.status as status_pengajuan FROM pengembalian p JOIN barang b ON p.id_barang = b.id JOIN pengajuan pj ON p.id_pengajuan = pj.id WHERE p.id_prajurit = ? ORDER BY p.tanggal_kembali DESC");
        $stmt->bind_param("i", $id_prajurit);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public static function getVerifikasi() {
        global $conn;
        return $conn->query("SELECT p.*, u.nama_lengkap as prajurit, b.nama_barang FROM pengembalian p JOIN users u ON p.id_prajurit = u.id JOIN barang b ON p.id_barang = b.id WHERE p.status = 'diajukan' ORDER BY p.tanggal_kembali ASC");
    }
    
    public static function terima($id) {
        global $conn;
        $conn->begin_transaction();
        try {
            $q = $conn->query("SELECT id_barang, jumlah_kembali FROM pengembalian WHERE id = $id");
            $data = $q->fetch_assoc();
            $conn->query("UPDATE pengembalian SET status='diterima' WHERE id=$id");
            $conn->query("UPDATE barang SET stok = stok + {$data['jumlah_kembali']} WHERE id = {$data['id_barang']}");
            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
    }
}
?>