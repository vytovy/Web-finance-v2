<?php
include 'config/config_db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$invoice_id = $_GET['id'];

// Hapus data detail invoice terlebih dahulu
$query_details = "DELETE FROM invoice_detail WHERE invoice_id = $invoice_id";
$conn->query($query_details);

// Hapus data header invoice
$query_invoice = "DELETE FROM invoice WHERE id = $invoice_id";
if ($conn->query($query_invoice)) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting invoice: " . $conn->error;
}
?>
