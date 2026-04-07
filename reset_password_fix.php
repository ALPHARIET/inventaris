<?php
require_once 'config/database.php';

$password_baru = '12345678';
$hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);

// Update semua user
$sql = "UPDATE users SET password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hash_baru);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "✅ Password semua user berhasil diubah menjadi: <strong>12345678</strong><br>";
    echo "Hash baru: " . $hash_baru . "<br><br>";
    
    // Tampilkan daftar user
    $result = $conn->query("SELECT id, username, role FROM users");
    echo "<h3>Daftar User Sekarang:</h3><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>Username: {$row['username']} | Role: {$row['role']}</li>";
    }
    echo "</ul>";
    echo "<a href='views/login.php'>Klik untuk login</a>";
} else {
    echo "❌ Gagal update. Cek apakah tabel users berisi data.";
}
?>