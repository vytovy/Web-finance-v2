<?php
include 'config/config_db.php';

// Pastikan parameter id dan invoice_id ada
if (!isset($_GET['id']) || !isset($_GET['invoice_id'])) {
    header("Location: index.php");
    exit;
}

$detail_id = $_GET['id'];
$invoice_id = $_GET['invoice_id'];

// Proses update data detail invoice
if (isset($_POST['update'])) {
    $deskripsi = $_POST['deskripsi'];
    $jarak     = $_POST['jarak'];
    $tanggal   = $_POST['tanggal'];
    $harga     = $_POST['harga'];
    
    $query = "UPDATE invoice_detail SET deskripsi='$deskripsi', jarak='$jarak', tanggal='$tanggal', harga='$harga' WHERE id=$detail_id";
    if ($conn->query($query)) {
        header("Location: detail_invoice.php?id=".$invoice_id);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data detail invoice yang akan diedit
$query = "SELECT * FROM invoice_detail WHERE id = $detail_id";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $detail = $result->fetch_assoc();
} else {
    echo "Detail data tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Detail Invoice</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Detail Invoice</h2>
  <form method="post">
    <div class="form-group">
      <label>Deskripsi</label>
      <input type="text" name="deskripsi" class="form-control" value="<?php echo $detail['deskripsi']; ?>" required>
    </div>
    <div class="form-group">
      <label>Jarak</label>
      <input type="number" step="0.01" name="jarak" class="form-control" value="<?php echo $detail['jarak']; ?>" required>
    </div>
    <div class="form-group">
      <label>Tanggal</label>
      <input type="date" name="tanggal" class="form-control" value="<?php echo $detail['tanggal']; ?>" required>
    </div>
    <div class="form-group">
      <label>Harga</label>
      <input type="number" step="0.01" name="harga" class="form-control" value="<?php echo $detail['harga']; ?>" required>
    </div>
    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="detail_invoice.php?id=<?php echo $invoice_id; ?>" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
