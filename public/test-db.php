<?php
require_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if($conn) {
    echo "✅ Koneksi database berhasil!<br>";
    echo "Database: registration_system<br>";
    
    $query = "SHOW TABLES LIKE 'users'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    if($stmt->rowCount() > 0) {
        echo "✅ Tabel 'users' ditemukan!<br>";
        
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        
        echo "📊 Jumlah user terdaftar: " . $result['total'];
    } else {
        echo "❌ Tabel 'users' tidak ditemukan!";
    }
} else {
    echo "❌ Koneksi database gagal!";
}
?>
