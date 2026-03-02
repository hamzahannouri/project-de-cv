<?php
// public/index.php
// Point d'entrée principal (Front Controller)

// Inclusion des fichiers nécessaires
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Models/Job.php';
require_once __DIR__ . '/../src/Controllers/HomeController.php';

// Routeur très basique
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
// Gestion du chemin si le projet est dans un sous-dossier (ex: localhost/monprojet/public/)
$path = str_replace($scriptName, '', $uri);

$controller = new HomeController();

if ($path === '/' || $path === '/index.php' || $path === '') {
    $controller->index();
} else {
    // Page 404 basique
    http_response_code(404);
    echo "<h1>Page non trouvée (404)</h1>";
    echo "<a href='" . $scriptName . "/'>Retour à l'accueil</a>";
}
