<?php 

require_once 'Database.php';

class DatabaseFactory {
    public static function create(array $config): Database
    {
        $dbConfig = $config['database'];

        if (!isset($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password'])){
            throw new InvalidArgumentException("Database configuration is incomplete in the config array.");
        }
        
        return new Database(
            $dbConfig['dsn'],
            $dbConfig['username'],
            $dbConfig['password']
        );
    }
}