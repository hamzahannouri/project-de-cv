<?php
// src/Models/Job.php

class Job {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Recherche multicritère des offres d'emploi
     * Pdo prepared statements pour prévenir les injections SQL
     */
    public function search($keyword, $location, $jobType, $isRemote) {
        $query = "SELECT j.*, u.company_name 
                  FROM jobs j 
                  JOIN users u ON j.recruiter_id = u.id 
                  WHERE j.status = 'active'";
        $params = [];

        // Recherche par mot-clé (métier, titre, ou description)
        if (!empty($keyword)) {
            $query .= " AND (j.title LIKE :keyword OR j.description LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        // Recherche par localisation géographique
        if (!empty($location)) {
            $query .= " AND j.location LIKE :location";
            $params[':location'] = '%' . $location . '%';
        }

        // Filtre de type de contrat
        if (!empty($jobType) && $jobType !== 'all') {
            $query .= " AND j.job_type = :jobType";
            $params[':jobType'] = $jobType;
        }

        // Filtre Télétravail
        if ($isRemote === '1') {
            $query .= " AND j.is_remote = 1";
        }

        $query .= " ORDER BY j.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
