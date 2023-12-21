<?php

use PDO;
use PDOException;

class EntityCollection
{
    private $database;
    private $tableName;

    public function __construct(
        $tableName,
        $host = 'localhost',
        $dbname = 'your_database_name',
        $username = 'your_username',
        $password = 'your_password'
    ) {
        try {
            $this->database = new Database($host, $dbname, $username, $password);
            $this->tableName = $tableName;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'initialisation de EntityCollection : " . $e->getMessage());
        }
    }

    public function getAll($fetchMode = PDO::FETCH_ASSOC)
    {
        try {
            $query = "SELECT * FROM {$this->tableName}";
            $statement = $this->database->getPdo()->prepare($query);
            $statement->execute();

            return $statement->fetchAll($fetchMode);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de tous les éléments : " . $e->getMessage());
        }
    }

    public function getById($id, $fetchMode = PDO::FETCH_ASSOC)
    {
        try {
            $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
            $statement = $this->database->getPdo()->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetch($fetchMode);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de l'élément par ID : " . $e->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $query = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$values})";
            $statement = $this->database->getPdo()->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            $statement->execute();

            return $this->database->getPdo()->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de l'élément : " . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $setClause = implode(", ", array_map(fn ($key) => "$key = :$key", array_keys($data)));

            $query = "UPDATE {$this->tableName} SET {$setClause} WHERE id = :id";
            $statement = $this->database->getPdo()->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            return $statement->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de l'élément : " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM {$this->tableName} WHERE id = :id";
            $statement = $this->database->getPdo()->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            return $statement->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'élément : " . $e->getMessage());
        }
    }
}
