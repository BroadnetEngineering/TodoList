<?php
class MySQL {
    public $pdo = null;

    public function __construct(Array $config) {
        $dsn = "mysql:dbname={$config['mysql_db_name']};host={$config['mysql_ip']}";
        $user = $config['mysql_user_name'];
        $password = $config['mysql_user_password'];

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            return $this;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getPdo() {
        if($this->pdo instanceof \PDO) {
            return $this->pdo;
        } else {
            throw new Error('MySQL connection is not established.');
        }
    }
}