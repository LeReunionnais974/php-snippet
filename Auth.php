<?php

class Auth
{
    protected $database;

    public function __construct(
        $host = 'localhost',
        $dbname = 'your_database_name',
        $username = 'your_username',
        $password = 'your_password'
    ) {
        try {
            $this->database = new Database($host, $dbname, $username, $password);
        } catch (Exception $e) {
            error_log("Erreur lors de l'initialisation de la base de données : " . $e->getMessage());
            throw new Exception("Erreur lors de l'initialisation de la base de données");
        }
    }

    public function authenticate($username, $password)
    {
        try {
            $user = $this->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            error_log("Erreur d'authentification : " . $e->getMessage());
            throw new Exception("Erreur d'authentification");
        }
    }

    protected function getUserByUsername($username)
    {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $this->database->getPdo()->prepare($query);
            $statement->bindParam(':username', $username);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            throw new Exception("Erreur lors de la récupération de l'utilisateur");
        }
    }
}
