<?php

$host = '127.0.0.1'; // หรือ localhost
$db   = 'sos';
$user = 'root';      // แก้ไข user ของ Database คุณ
$pass = '';          // แก้ไข password ของ Database คุณ
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("<h2 style='color:red;'>ไม่สามารถเชื่อมต่อฐานข้อมูลได้: " . $e->getMessage() . "</h2><p>กรุณาตรวจสอบชื่อผู้ใช้ รหัสผ่าน และการสร้าง Database 'sos'</p>");
}
?>