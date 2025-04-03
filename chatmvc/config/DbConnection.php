<?php

namespace MyApp\Config;

class DbConnection
{
    private static $instance = null;
    private $connection;


    private function __construct()
    {
        $dbHost     = 'localhost'; // Replace with your actual database host
        $dbUser     = 'root'; // Replace with your actual database user
        $dbPassword = 'root'; // Replace with your actual database password
        $dbName     = 'messagerie'; // Replace with your actual database name
        
        try
        {
            $this->connection = new \PDO("mysql:host=".$dbHost.";dbname=".$dbName, $dbUser, $dbPassword);
        }
        catch (\PDOException $e) {
	        // Echec de la connexion
            exit("Erreur: " . $e->getMessage());
        }
    }


    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
