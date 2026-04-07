<?php
require_once '../config/database.php';
require_once '../models/BarangModel.php';
require_once '../models/KategoriModel.php';

if(!isset($_SESSION['role']) || $_SESSION['role']!='petugas') die("Akses ditolak");

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

if ($action == 'create') {
    // Ambil data dari form barang
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    
    BarangModel::create($nama_barang, $id_kategori, $stok, $satuan);
    header("Location: ../views/barang/index.php");
    exit;
} 
elseif ($action == 'update') {
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    
    BarangModel::update($id, $nama_barang, $id_kategori, $stok, $satuan);
    header("Location: ../views/barang/index.php");
    exit;
} 
elseif ($action == 'delete') {
    BarangModel::delete($id);
    header("Location: ../views/barang/index.php");
    exit;
}
?>