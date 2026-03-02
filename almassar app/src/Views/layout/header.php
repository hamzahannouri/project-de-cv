<?php
// src/Views/layout/header.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Massar Jobs | Le portail de recrutement</title>
    <!-- Utilisation du chemin absolu par rapport à public/ -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="/" class="logo">
                <span class="logo-highlight">Al-Massar</span> Jobs
            </a>
            <nav class="main-nav" aria-label="Navigation Principale">
                <ul>
                    <li><a href="/">Offres d'emploi</a></li>
                    <li><a href="/login" class="btn btn-outline btn-sm">Espace Recruteur</a></li>
                    <li><a href="/register" class="btn btn-primary btn-sm">Connexion Candidat</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">
