<?php
class Database
{
    private $host = "existing_database_host";
    private $db_name = "existing_database_name";
    private $username = "existing_database_username";
    private $password = "existing_database_password";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
