<?php
// config/database.php

class Database {
    private static $instance = null;
    private $connection;

    // Configuration via variables d'environnement (Docker) ou valeurs par défaut
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset = 'utf8mb4';

    private function __construct() {
        $this->host = getenv('DB_HOST') ?: '127.0.0.1';
        $this->db   = getenv('DB_NAME') ?: 'almassar_jobs';
        $this->user = getenv('DB_USER') ?: 'root';
        $this->pass = getenv('DB_PASSWORD') ?: '';
        
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
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
