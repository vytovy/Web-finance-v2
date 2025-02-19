<?php
include 'config/config_db.php';

if(!isset($_GET['invoice_id'])){
   header("Location: index.php");
   exit;
}
$invoice_id = $_GET['invoice_id'];

if(isset($_POST['simpan'])){
   $deskripsi = $_POST['deskripsi'];
   $jarak = $_POST['jarak'];
   $tanggal = $_POST['tanggal'];
   $harga = $_POST['harga'];
   
   $query = "INSERT INTO invoice_detail (invoice_id, deskripsi, jarak, tanggal, harga)
             VALUES ($invoice_id, '$deskripsi', '$jarak', '$tanggal', '$harga')";
   if($conn->query($query)){
       header("Location: detail_invoice.php?id=" . $invoice_id);
       exit;
   } else {
       echo "Error: " . $conn->error;
   }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- Meta viewport untuk responsivitas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tambah Data Invoice Detail</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Tambah Data Invoice Detail</h2>
  <form method="post">
    <div class="form-group">
      <label>Deskripsi</label>
      <input type="text" name="deskripsi" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Jarak</label>
      <input type="number" step="0.01" name="jarak" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Tanggal</label>
      <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Harga</label>
      <input type="number" step="0.01" name="harga" class="form-control" required>
    </div>
    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
    <a href="detail_invoice.php?id=<?php echo $invoice_id; ?>" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
