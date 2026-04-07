<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit;
}

function isPetugas() {
    return $_SESSION['role'] == 'petugas';
}

function isPrajurit() {
    return $_SESSION['role'] == 'prajurit';
}
?>