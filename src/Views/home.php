<?php
// src/Views/home.php
// Attente de variables : $keyword, $location, $jobType, $isRemote, $jobs, $isSearch
?>

<section class="hero-section">
    <div class="container">
        <h1>Trouvez le job de vos rêves</h1>
        <p class="hero-subtitle">Des milliers d'offres d'emploi en CDI, CDD, Freelance et Alternance.</p>

        <form action="/" method="GET" class="search-form" aria-label="Formulaire de recherche d'offres d'emploi">
            <div class="search-inputs-group">
                <div class="input-group">
                    <label for="keyword" class="sr-only">Métier, mots-clés ou entreprise</label>
                    <input type="text" id="keyword" name="keyword" placeholder="Métier, mots-clés ou entreprise" value="<?= $keyword ?>">
                </div>
                <div class="input-group">
                    <label for="location" class="sr-only">Ville, région ou code postal</label>
                    <input type="text" id="location" name="location" placeholder="Ville, région..." value="<?= $location ?>">
                </div>
                <div class="input-group">
                    <label for="job_type" class="sr-only">Type de contrat</label>
                    <select id="job_type" name="job_type">
                        <option value="all" <?= $jobType === 'all' ? 'selected' : '' ?>>Tous les contrats</option>
                        <option value="CDI" <?= $jobType === 'CDI' ? 'selected' : '' ?>>CDI</option>
                        <option value="CDD" <?= $jobType === 'CDD' ? 'selected' : '' ?>>CDD</option>
                        <option value="Freelance" <?= $jobType === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                        <option value="Alternance" <?= $jobType === 'Alternance' ? 'selected' : '' ?>>Alternance</option>
                        <option value="Stage" <?= $jobType === 'Stage' ? 'selected' : '' ?>>Stage</option>
                    </select>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="is_remote" name="is_remote" value="1" <?= $isRemote === '1' ? 'checked' : '' ?>>
                    <label for="is_remote">Télétravail uniquement</label>
                </div>
                <button type="submit" class="btn btn-primary btn-search">Rechercher</button>
            </div>
        </form>
    </div>
</section>

<section class="results-section container">
    <h2><?= $isSearch ? "Résultats de votre recherche" : "Dernières offres d'emploi" ?></h2>
    
    <div class="jobs-layout">
        <!-- Liste des résultats -->
        <div class="jobs-list">
            <?php if (!empty($jobs)): ?>
                <?php foreach ($jobs as $job): ?>
                    <article class="job-card">
                        <div class="job-card-header">
                            <div>
                                <h3 class="job-title"><?= htmlentities($job['title']) ?></h3>
                                <span class="company-name"><?= htmlentities($job['company_name']) ?></span>
                            </div>
                        </div>
                        <div class="job-meta">
                            <span class="badge badge-location"><?= htmlentities($job['location']) ?></span>
                            <span class="badge badge-type"><?= htmlentities($job['job_type']) ?></span>
                            <?php if ($job['is_remote']): ?>
                                <span class="badge badge-remote">Télétravail</span>
                            <?php endif; ?>
                        </div>
                        <p class="job-excerpt">
                            <?= htmlentities(substr($job['description'], 0, 150)) ?>...
                        </p>
                        <div class="job-actions">
                            <a href="/job/<?= $job['id'] ?>" class="btn btn-outline btn-sm">Voir l'offre</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>Aucune offre ne correspond à vos critères de recherche. Essayez de modifier vos filtres.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Placeholder pour la carte (Géolocalisation) -->
        <aside class="jobs-map-sidebar">
            <div class="map-placeholder">
                <p>Carte interactive des offres (Carte placeholder)</p>
            </div>
        </aside>
    </div>
</section>
