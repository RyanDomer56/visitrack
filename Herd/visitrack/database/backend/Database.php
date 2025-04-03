<?php 

class Database {
    private $pdo; 

    public function __construct(string $dsn, string $username, string $password)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            // Set PDO attributes for better error handling and performance (optional but good practice)
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);// Or other fetch mode you prefer 
        }
        catch (PDOException $e){
            // In a real application, you might want to handle this exception more gracefully,
            // log it, or throw a custom exception.
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO 
    {
        return $this->pdo;
    }
}