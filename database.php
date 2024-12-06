<?php
class Database {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->connection->connect_errno) {
            die("Échec de la connexion : " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("Échec de la requête : " . $this->connection->error);
        }
        return $result;
    }

    public function escape_string($string) {
        return $this->connection->real_escape_string($string);
    }
}
?>