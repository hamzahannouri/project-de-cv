<?php
// src/Controllers/HomeController.php

class HomeController {
    
    public function index() {
        $jobModel = new Job();
        
        // Nettoyage basique des entrées GET (prévention XSS)
        // Les filtres complexes doivent être validés en amont
        $keyword = isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : '';
        $location = isset($_GET['location']) ? htmlspecialchars(trim($_GET['location'])) : '';
        $jobType = isset($_GET['job_type']) ? htmlspecialchars(trim($_GET['job_type'])) : 'all';
        $isRemote = isset($_GET['is_remote']) ? '1' : '0';

        // Est-ce une requête de recherche ou l'accueil par défaut ?
        $isSearch = !empty($keyword) || !empty($location) || $jobType !== 'all' || $isRemote === '1';

        $jobs = [];
        if ($isSearch) {
            $jobs = $jobModel->search($keyword, $location, $jobType, $isRemote);
        } else {
            // Par défaut, afficher toutes les offres récentes sans critères
            $jobs = $jobModel->search('', '', 'all', '0'); 
        }

        // Transmission des données à la Vue
        $data = [
            'keyword' => $keyword,
            'location' => $location,
            'jobType' => $jobType,
            'isRemote' => $isRemote,
            'jobs' => $jobs,
            'isSearch' => $isSearch
        ];

        // Rendu de la page
        $this->render('home', $data);
    }

    /**
     * Moteur de rendu de template ultra simple
     */
    private function render($view, $data = []) {
        // Expose les variables du tableau $data dans l'espace global de la vue
        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            // Création d'une structure de base avec Header, CoreView et Footer
            require_once __DIR__ . '/../Views/layout/header.php';
            require_once $viewFile;
            require_once __DIR__ . '/../Views/layout/footer.php';
        } else {
            http_response_code(500);
            die("View template `$view` not found.");
        }
    }
}
