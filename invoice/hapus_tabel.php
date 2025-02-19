<?php
include 'config/config_db.php';

// Pastikan parameter 'id' (ID detail) dan 'invoice_id' (ID invoice induk) tersedia
if (!isset($_GET['id']) || !isset($_GET['invoice_id'])) {
    header("Location: index.php");
    exit;
}

$detail_id = $_GET['id'];
$invoice_id = $_GET['invoice_id'];

// Hapus data detail invoice berdasarkan ID
$query = "DELETE FROM invoice_detail WHERE id = $detail_id";
if ($conn->query($query)) {
    header("Location: detail_invoice.php?id=" . $invoice_id);
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
