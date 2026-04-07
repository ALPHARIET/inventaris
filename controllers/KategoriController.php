<?php
require_once '../config/database.php';
require_once '../models/KategoriModel.php';

if(!isset($_SESSION['role']) || $_SESSION['role']!='petugas') die("Akses ditolak");

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

if ($action == 'create') {
    $nama = $_POST['nama_kategori'];
    KategoriModel::create($nama);
    header("Location: ../views/kategori/index.php");
} elseif ($action == 'update') {
    $nama = $_POST['nama_kategori'];
    KategoriModel::update($id, $nama);
    header("Location: ../views/kategori/index.php");
} elseif ($action == 'delete') {
    KategoriModel::delete($id);
    header("Location: ../views/kategori/index.php");
}
?>