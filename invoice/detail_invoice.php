<?php
include 'config/config_db.php';

if(isset($_GET['id'])){
    $invoice_id = $_GET['id'];
    
    // Ambil data header invoice
    $query_invoice = "SELECT * FROM invoice WHERE id = $invoice_id";
    $result_invoice = $conn->query($query_invoice);
    $invoice = $result_invoice->fetch_assoc();
    
    // Ambil data detail invoice
    $query_details = "SELECT * FROM invoice_detail WHERE invoice_id = $invoice_id";
    $result_details = $conn->query($query_details);
    
    // Hitung total pembayaran
    $total = 0;
    $details = [];
    while($row = $result_details->fetch_assoc()){
        $total += $row['harga'];
        $details[] = $row;
    }
} else {
    header("Location: index.php");
    exit;
}

// Fungsi untuk mengubah nama hari ke bahasa Indonesia
function hariIndonesia($day){
    $days = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    return $days[$day] ?? $day;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Detail Invoice Travel</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <style>
    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      background-color: #007bff;
      color: #fff;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 20px;
    }
    .invoice-footer {
      border-top: 2px solid #000;
      padding-top: 10px;
      margin-top: 20px;
      text-align: center;
      background-color: #fff;
    }
    .invoice-container {
      background: #fff;
      padding: 20px;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <div id="invoice-content" class="invoice-container">
    <div class="invoice-header">
      <div>
        <h5>Invoice: <?php echo $invoice['no_invoice']; ?></h5>
        <p>Status: <?php echo $invoice['status']; ?></p>
      </div>
      <div>
        <h5><?php echo $invoice['nama']; ?></h5>
        <p><?php echo $invoice['alamat_rumah']; ?></p>
      </div>
    </div>
    
    <div class="mb-3 no-download">
      <a href="data_tabel.php?invoice_id=<?php echo $invoice_id; ?>" class="btn btn-primary">Tambah Data Tabel</a>
    </div>
    
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Deskripsi</th>
            <th>Jarak</th>
            <th>Tanggal</th>
            <th>Hari</th>
            <th>Harga</th>
            <th class="no-download">Aksi</th>
          </tr>
        </thead>
        <tbody>
            
            <?php 
            if(!empty($details)){
              foreach($details as $detail){
                $tanggal = $detail['tanggal'];
                $hari = hariIndonesia(date('l', strtotime($tanggal))); // Nama hari dalam Bahasa Indonesia
          ?>
     
          <tr>
            <td><?php echo $detail['deskripsi']; ?></td>
            <td><?php echo $detail['jarak']; ?></td>
            <td><?php echo $tanggal; ?></td>
            <td><?php echo $hari; ?></td>
            <td><?php echo number_format($detail['harga'], 2); ?></td>
            <td class="no-download">
              <a href="edit_tabel.php?id=<?php echo $detail['id']; ?>&invoice_id=<?php echo $invoice_id; ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="hapus_tabel.php?id=<?php echo $detail['id']; ?>&invoice_id=<?php echo $invoice_id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data detail ini?')">Hapus</a>
            </td>
          </tr>
          <?php 
              }
            } else {
              echo '<tr><td colspan="6" class="text-center">Belum ada data detail</td></tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
    
    <div class="invoice-footer">
      <h5 style="color:#007bff;">Total Pembayaran: <?php echo number_format($total, 2); ?></h5>
      <p>Terima kasih telah menggunakan jasa travel kami.</p>
    </div>
  </div>
  
  <div class="mt-3 no-download">
    <button class="btn btn-primary" onclick="editInvoice()">Edit</button>
    <button class="btn btn-danger" onclick="hapusInvoice()">Hapus</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
    <button class="btn btn-success" onclick="downloadImage()">Simpan ke dalam Gambar</button>
  </div>
</div>

<script>
function downloadImage(){
    var elements = document.querySelectorAll(".no-download");
    var originalDisplays = [];
    for(var i = 0; i < elements.length; i++){
        originalDisplays[i] = elements[i].style.display;
        elements[i].style.display = 'none';
    }
    
    html2canvas(document.querySelector("#invoice-content")).then(canvas => {
        var link = document.createElement('a');
        link.href = canvas.toDataURL();
        link.download = 'invoice_<?php echo $invoice['no_invoice']; ?>.png';
        link.click();
        for(var i = 0; i < elements.length; i++){
            elements[i].style.display = originalDisplays[i];
        }
    });
}

function editInvoice(){
    window.location.href = "edit_invoice.php?id=<?php echo $invoice_id; ?>";
}

function hapusInvoice(){
    if(confirm('Apakah Anda yakin ingin menghapus invoice ini?')){
        window.location.href = "hapus_invoice.php?id=<?php echo $invoice_id; ?>";
    }
}
</script>
</body>
</html>
