<?php

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct(
        $host = 'localhost',
        $dbname = 'your_database_name',
        $username = 'your_username',
        $password = 'your_password'
    ) {
        try {
            $this->pdo = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
