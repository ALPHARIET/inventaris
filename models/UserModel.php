<?php
class UserModel {
    public static function getUserByUsername($username) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>