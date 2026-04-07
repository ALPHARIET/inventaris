<?php
require_once '../config/database.php';
require_once '../models/UserModel.php';

$action = $_GET['action'] ?? '';

if ($action == 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = UserModel::getUserByUsername($username);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama'] = $user['nama_lengkap'];
        
        if ($user['role'] == 'petugas') {
            header("Location: ../views/dashboard_petugas.php");
        } else {
            header("Location: ../views/dashboard_prajurit.php");
        }
        exit;
    } else {
        header("Location: ../views/login.php?error=1");
        exit;
    }
} elseif ($action == 'logout') {
    session_destroy();
    header("Location: ../views/login.php");
    exit;
}
?>