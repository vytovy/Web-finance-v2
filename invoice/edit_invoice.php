<?php
include 'config/config_db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$invoice_id = $_GET['id'];

// Proses update data tanpa field harga dan no_invoice (tidak dapat diedit)
if (isset($_POST['update'])) {
    $nama         = $_POST['nama'];
    $alamat_rumah = $_POST['alamat_rumah'];
    $status       = $_POST['status'];

    $query = "UPDATE invoice SET 
                nama='$nama', 
                alamat_rumah='$alamat_rumah', 
                status='$status'
              WHERE id=$invoice_id";
    if ($conn->query($query)) {
        header("Location: detail_invoice.php?id=" . $invoice_id);
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Ambil data invoice untuk ditampilkan dalam form
$query_invoice = "SELECT * FROM invoice WHERE id = $invoice_id";
$result_invoice = $conn->query($query_invoice);
if ($result_invoice->num_rows > 0) {
    $invoice = $result_invoice->fetch_assoc();
} else {
    echo "Invoice tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- Meta viewport untuk responsivitas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Invoice Travel</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Invoice Travel</h2>
  <form method="post">
    <div class="form-group">
      <label>No Invoice</label>
      <input type="text" name="no_invoice" class="form-control" value="<?php echo $invoice['no_invoice']; ?>" readonly>
    </div>
    <div class="form-group">
      <label>Nama Klien</label>
      <input type="text" name="nama" class="form-control" value="<?php echo $invoice['nama']; ?>" required>
    </div>
    <div class="form-group">
      <label>Alamat Rumah</label>
      <input type="text" name="alamat_rumah" class="form-control" value="<?php echo $invoice['alamat_rumah']; ?>" required>
    </div>
<div class="form-group">
  <label>Status</label>
  <select name="status" class="form-control" required>
    <option value="belum lunas" <?php if($invoice['status'] == 'belum lunas') echo 'selected'; ?>>Belum Lunas</option>
    <option value="lunas" <?php if($invoice['status'] == 'lunas') echo 'selected'; ?>>Lunas</option>
    <option value="cicilan" <?php if($invoice['status'] == 'cicilan') echo 'selected'; ?>>Cicilan</option>
    <option value="rencana perjalanan" <?php if($invoice['status'] == 'rencana perjalanan') echo 'selected'; ?>>Rencana Perjalanan</option>
  </select>
</div>

    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="detail_invoice.php?id=<?php echo $invoice_id; ?>" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
