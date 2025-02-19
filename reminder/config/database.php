<?php

class Database {
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "password_baru";
    private $database = "finance";
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

?>