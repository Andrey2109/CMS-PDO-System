<?php

class Database
{

    private $host = DB_HOST;
    private $dbName =  DB_NAME;
    private $dbPass = DB_PASS;
    private $dbUser = DB_USER;

    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->dbUser, $this->dbPass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error" . $exception->getMessage();
        }

        return $this->conn;
    }
}
