<?php
// file: tambah_data.php
include 'config/database.php';
include 'models/reminder.php';

$database = new Database();
$conn = $database->getConnection();
$reminder = new Reminder($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];
    if ($reminder->tambahReminder($tanggal, $deskripsi, $status)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal menambah data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Reminder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Tambah Data Reminder</h1>
    <form method="post">
        <div class="form-group">
            <label>Tanggal Janji</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Belum Dikonfirmasi">Belum Dikonfirmasi</option>
                <option value="Dikonfirmasi">Dikonfirmasi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/reminder/index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
