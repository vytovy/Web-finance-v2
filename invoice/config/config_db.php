<?php
$host = "127.0.0.1";
$user = "root";
$password = "password_baru";
$database = "finance";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
