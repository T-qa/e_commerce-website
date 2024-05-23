<?php
session_start();
class DBConnect
{
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'e_commerce';
    private $conn;
    function connect()
    {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            echo "Connection Failed";
        } else {
           return $this->conn;
        }
    }
}