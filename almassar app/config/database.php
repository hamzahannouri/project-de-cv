<?php
// config/database.php

class Database {
    private static $instance = null;
    private $connection;

    // A configurer selon l'environnement de développement
    private $host = '127.0.0.1';
    private $db   = 'almassar_jobs';
    private $user = 'root'; 
    private $pass = ''; 
    private $charset = 'utf8mb4';

    private function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Désactiver l'émulation des requêtes préparées pour la sécurité
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            // En production, logger l'erreur plutôt que de l'afficher
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
