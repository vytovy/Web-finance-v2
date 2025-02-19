<?php
// index.php

// Koneksi ke database MySQL
$servername = "127.0.0.1";
$username   = "root";
$password   = "password_baru";
$database   = "finance";

$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


// Rentang untuk minggu ini
$startOfWeek = date("Y-m-d", strtotime("monday this week"));
$endOfWeek   = date("Y-m-d", strtotime("sunday this week"));

// Rentang untuk bulan ini
$startOfMonth = date("Y-m-01");
$endOfMonth   = date("Y-m-t");

// Mengambil parameter range (default: weekly)
$range = isset($_GET['range']) ? $_GET['range'] : 'weekly';

if ($range == 'monthly') {
    $startDate = $startOfMonth;
    $endDate   = $endOfMonth;
} else {
    $startDate = $startOfWeek;
    $endDate   = $endOfWeek;
}

   $sqlPie = "SELECT et.nama_tag as tag_name, SUM(t.jumlah) as total 
           FROM transactions t 
           JOIN expense_tags et ON t.tag_id = et.id 
           WHERE t.tanggal BETWEEN '$startDate' AND '$endDate'
           GROUP BY t.tag_id";

// Query untuk chart lingkaran (Pie Chart)
// Mengambil total 'jumlah' transaksi berdasarkan tag
//$sqlPie = "SELECT et.nama_tag as tag_name, SUM(t.jumlah) as total 
 //          FROM transactions t 
 //          JOIN expense_tags et ON t.tag_id = et.id 
//           GROUP BY t.tag_id";
$resultPie = $conn->query($sqlPie);

$pieLabels = [];
$pieData   = [];
if ($resultPie && $resultPie->num_rows > 0) {
    while ($row = $resultPie->fetch_assoc()) {
        $pieLabels[] = $row['tag_name'];
        $pieData[]   = $row['total'];
    }
}

// Query untuk chart batang (Bar Chart)
// Mengambil total 'jumlah' transaksi per tanggal
$sqlBar = "SELECT tanggal, SUM(jumlah) as total 
          FROM transactions 
         GROUP BY tanggal 
         ORDER BY tanggal ASC";


$resultBar = $conn->query($sqlBar);

$barLabels = [];
$barData   = [];
if ($resultBar && $resultBar->num_rows > 0) {
    while ($row = $resultBar->fetch_assoc()) {
        $barLabels[] = $row['tanggal'];
        $barData[]   = $row['total'];
    }
}




$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Finance Charts</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Finance Charts</h2>
    
    <div class="row">
        <!-- Chart Lingkaran -->
        <div class="col-md-6">
            <h4>Transaksi Berdasarkan Tag (Pie Chart)</h4>
            <canvas id="pieChart"></canvas>
        </div>
        <!-- Chart Batang -->
        <div class="col-md-6">
            <h4>Transaksi Berdasarkan Tanggal (Bar Chart)</h4>
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

<script>
// Mengambil data dari PHP
var pieLabels = <?php echo json_encode($pieLabels); ?>;
var pieData   = <?php echo json_encode($pieData); ?>;

var barLabels = <?php echo json_encode($barLabels); ?>;
var barData   = <?php echo json_encode($barData); ?>;

// Konfigurasi Pie Chart
var ctxPie = document.getElementById('pieChart').getContext('2d');
var pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: pieLabels,
        datasets: [{
            data: pieData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ]
        }]
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'Total Jumlah per Tag'
        }
    }
});

// Konfigurasi Bar Chart
var ctxBar = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: barLabels,
        datasets: [{
            label: 'Total Jumlah',
            data: barData,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    },
    options: {
        responsive: true,
        title: {
            display: true,
            text: 'Total Jumlah per Tanggal'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<!-- Bootstrap JS dan dependensinya -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
