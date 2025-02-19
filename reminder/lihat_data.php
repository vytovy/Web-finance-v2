<?php
// file: lihat_data.php
require_once 'config/database.php';
require_once 'models/reminder.php';

$database = new Database();
$conn = $database->getConnection();
$reminder = new Reminder($conn);

$id = $_GET['id'] ?? null;
$data = $reminder->tampilkanReminder($id);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    $reminder->hapusReminder($id);
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];
    $reminder->editReminder($id, $tanggal, $deskripsi, $status);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<?php
require_once 'config/database.php';
require_once 'models/reminder.php';

$database = new Database();
$conn = $database->getConnection();
$reminder = new Reminder($conn);

// Inisialisasi $data_reminder dengan nilai default (array kosong)
$data_reminder = [];

// Eksekusi query dan periksa apakah ada hasil
$result = $reminder->tampilkanSemuaReminder();
if ($result) {  // Jika query berhasil dijalankan
    if ($result->num_rows > 0) { // Jika ada data
        while ($row = $result->fetch_assoc()) {
            $data_reminder[] = $row; // Tambahkan data ke array
        }
    } else {
        echo "Tidak ada data reminder."; // Tampilkan pesan jika tidak ada data
    }
} else {
    echo "Error executing query: " . $conn->error; // Tampilkan pesan error query
}
?>

<!DOCTYPE html>
<html>
<!--head>
    <title>Aplikasi Reminder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Reminder</h1>
        <a href="/reminder/tambah_data.php" class="btn btn-primary" data-toggle="modal" data-target="#tambahReminder">Tambah</a>
        <a href="../index.php" class="btn btn-primary" data-toggle="modal" data-target="#kembali">Kembali</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal Janji</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <//?php if (!empty($data_reminder)): // Pastikan $data_reminder tidak kosong ?>
                    <//?php foreach ($data_reminder as $row): ?>  <tr>
                            <td><//?= $row['tanggal_janji'] ?></td>
                            <td><//?= $row['deskripsi'] ?></td>
                            <td><//?= $row['status'] ?></td>
                            <td>
                                <a href="lihat_data.php?id=<//?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat</a>

                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusReminder<//?= $row['id'] ?>">Hapus</a>
                            </td>
                        </tr>
                        <//?php endforeach; ?>
                <?//php endif; ?>
            </tbody>
        </table>
        </div>
    </body>
</html-->
<head>
    <title>Lihat Data Reminder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Lihat Data Reminder</h1>
    <form method="post">
        <div class="form-group">
            <label>Tanggal Janji</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal_janji'] ?>" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" value="<?= $data['deskripsi'] ?>" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Belum Dikonfirmasi" <?= $data['status'] === 'Belum Dikonfirmasi' ? 'selected' : '' ?>>Belum Dikonfirmasi</option>
                <option value="Dikonfirmasi" <?= $data['status'] === 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
            </select>
        </div>
        <button type="submit" name="edit" class="btn btn-success">Edit</button>
        <button type="submit" name="hapus" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
