<?php
include 'config/database.php';
include 'models/reminder.php';

$database = new Database();
$conn = $database->getConnection();
$reminder = new Reminder($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data_reminder = $reminder->tampilkanReminder($id);
}

if ($data_reminder === null) {
    echo "Data reminder tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Reminder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Detail Reminder</h1>
        <table class="table">
            <tr>
                <th>Tanggal Janji</th>
                <td><?= $data_reminder['tanggal_janji'] ?></td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td><?= $data_reminder['deskripsi'] ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= $data_reminder['status'] ?></td>
            </tr>
        </table>
        <a href="index.php" class="btn btn-primary">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>