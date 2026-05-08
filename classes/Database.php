<?php

/* Database connection class */
class Database {

    /* Database host */
    private string $host = 'localhost';

    /* Database name */
    private string $dbName = 'real_estate_portal_db';

    /* Database username */
    private string $username = 'root';

    /* Database password */
    private string $password = '';

    /* PDO connection */
    private ?PDO $conn = null;

    /* Create database connection */
    public function connect(): PDO {

        if ($this->conn === null) {

            try {

                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4",
                    $this->username,
                    $this->password
                );

                $this->conn->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                $this->conn->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

            } catch (PDOException $e) {

                die("Database connection failed: " . $e->getMessage());
            }
        }

        return $this->conn;
    }
}