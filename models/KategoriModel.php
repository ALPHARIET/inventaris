<?php
class KategoriModel {
    public static function getAll() {
        global $conn;
        return $conn->query("SELECT * FROM kategori ORDER BY id DESC");
    }
    public static function getById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM kategori WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public static function create($nama) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $stmt->bind_param("s", $nama);
        return $stmt->execute();
    }
    public static function update($id, $nama) {
        global $conn;
        $stmt = $conn->prepare("UPDATE kategori SET nama_kategori=? WHERE id=?");
        $stmt->bind_param("si", $nama, $id);
        return $stmt->execute();
    }
    public static function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM kategori WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>