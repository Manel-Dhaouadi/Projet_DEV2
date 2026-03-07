<div class="home-page">
    <!-- Bannière d'accueil -->
    <section class="welcome-banner">
        <div class="container">
            <div class="banner-content">
                <h1 class="banner-title">
                    Trouvez le job <span class="gradient-text">de vos rêves</span>
                </h1>
                <p class="banner-subtitle"><?= htmlspecialchars($metaDescription) ?></p>
                
                <!-- Barre de recherche -->
                <form action="index.php" method="GET" class="search-container">
                    <input type="hidden" name="action" value="jobs">
                    <div class="search-wrapper">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="keyword" placeholder="Titre du poste, mots-clés..." class="search-field">
                        </div>
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </form>

                <!-- Tags populaires -->
                <div class="tags-container">
                    <span class="tags-label">Populaire :</span>
                    <a href="?action=jobs&type=CDI" class="tag-item">CDI</a>
                    <a href="?action=jobs&type=Stage" class="tag-item">Stage</a>
                    <a href="?action=jobs&type=Alternance" class="tag-item">Alternance</a>
                    <a href="?action=jobs&city=Tunis" class="tag-item">Tunis</a>
                    <a href="?action=jobs&city=Sfax" class="tag-item">Sfax</a>
                    <a href="?action=jobs&city=Sousse" class="tag-item">Sousse</a>
                </div>
            </div>
        </div>
    </section>

<!-- Statistiques -->
<section class="stats-panel">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-block">
                <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($stats['jobs'] ?? 0) ?>+</div>
                    <div class="stat-label">Offres d'emploi</div>
                </div>
            </div>
            
            <div class="stat-block">
                <div class="stat-icon"><i class="fas fa-building"></i></div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($stats['companies'] ?? 2500) ?>+</div>
                    <div class="stat-label">Entreprises</div>
                </div>
            </div>
            
            <div class="stat-block">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($stats['candidates'] ?? 10000) ?>+</div>
                    <div class="stat-label">Candidats</div>
                </div>
            </div>
            
            <div class="stat-block">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    <div class="stat-number"><?= $stats['satisfaction'] ?? 98 ?>%</div>
                    <div class="stat-label">Satisfaction</div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Offres à la une -->
    <?php if (!empty($featuredJobs)): ?>
    <section class="featured-jobs-panel">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Offres <span class="gradient-text">à la une</span></h2>
                <p class="section-description">Découvrez les meilleures opportunités du moment</p>
            </div>

            <div class="jobs-featured-grid">
                <?php foreach ($featuredJobs as $job): ?>
                <div class="job-featured-card">
                    <div class="featured-badge">À la une</div>
                    <h3 class="job-title"><?= htmlspecialchars($job['title']) ?></h3>
                    <div class="job-company-info">
                        <i class="fas fa-building"></i> <?= htmlspecialchars($job['company_name']) ?>
                    </div>
                    <div class="job-details-list">
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job['city']) ?></span>
                        <span><i class="fas fa-clock"></i> <?= htmlspecialchars($job['type']) ?></span>
                    </div>
                    <p class="job-description-preview">
                        <?= htmlspecialchars(substr($job['description'], 0, 120)) ?>...
                    </p>
                    <div class="job-card-footer">
                        <a href="?action=job&id=<?= $job['id'] ?>" class="job-view-link">
                            Voir l'offre <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="section-footer">
                <a href="?action=jobs" class="btn-view-all">
                    Voir toutes les offres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Catégories -->
    <section class="categories-panel">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Explorez par <span class="gradient-text">catégorie</span></h2>
                <p class="section-description">Trouvez l'offre qui correspond à votre profil</p>
            </div>

           