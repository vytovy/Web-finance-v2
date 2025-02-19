<?php
include 'config/database.php';
include 'models/reminder.php';

$database = new Database();
$conn = $database->getConnection();
$reminder = new Reminder($conn);

if (isset($_POST['tambah'])) {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    if ($reminder->tambahReminder($tanggal, $deskripsi)) {
        header("Location: /reminder/index.php"); // Redirect kembali ke index.php setelah berhasil menambah data
    } else {
        echo "Gagal menambahkan data reminder.";
    }
} elseif (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    if ($reminder->editReminder($id, $tanggal, $deskripsi, $status)) {
        header("Location: /reminder/index.php");
    } else {
        echo "Gagal mengedit data reminder.";
    }
} elseif (isset($_GET['hapus'])) {
    $id = $_GET['id'];

    if ($reminder->hapusReminder($id)) {
        header("Location: /reminder/index.php");
    } else {
        echo "Gagal menghapus data reminder.";
    }
}
?>