<?php

class Reminder {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function tampilkanSemuaReminder() {
        $sql = "SELECT * FROM reminder ORDER BY tanggal_janji ASC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function tampilkanReminder($id) {
        $sql = "SELECT * FROM reminder WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

// Perbarui metode tambahReminder di models/reminder.php
    
    
    public function tambahReminder($tanggal, $deskripsi, $status) {
        $sql = "INSERT INTO reminder (tanggal_janji, deskripsi, status) VALUES ('$tanggal', '$deskripsi', '$status')";
        return $this->conn->query($sql);
    }



    public function editReminder($id, $tanggal, $deskripsi, $status) {
        $sql = "UPDATE reminder SET tanggal_janji = '$tanggal', deskripsi = '$deskripsi', status = '$status' WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function hapusReminder($id) {
        $sql = "DELETE FROM reminder WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function konfirmasiReminder($id) {
        $sql = "UPDATE reminder SET status = 'Dikonfirmasi' WHERE id = $id";
        return $this->conn->query($sql);
    }
}

?>