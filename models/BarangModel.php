<?php
class BarangModel {
    public static function getAll() {
        global $conn;
        return $conn->query("SELECT b.*, k.nama_kategori FROM barang b JOIN kategori k ON b.id_kategori = k.id ORDER BY b.id DESC");
    }
    public static function getById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM barang WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public static function create($nama, $id_kategori, $stok, $satuan) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, id_kategori, stok, satuan) VALUES (?,?,?,?)");
        $stmt->bind_param("siis", $nama, $id_kategori, $stok, $satuan);
        return $stmt->execute();
    }
    public static function update($id, $nama, $id_kategori, $stok, $satuan) {
        global $conn;
        $stmt = $conn->prepare("UPDATE barang SET nama_barang=?, id_kategori=?, stok=?, satuan=? WHERE id=?");
        $stmt->bind_param("siisi", $nama, $id_kategori, $stok, $satuan, $id);
        return $stmt->execute();
    }
    public static function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM barang WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>