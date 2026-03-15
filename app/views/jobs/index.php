<div class="jobs-page">
    <!-- En-tête de la page -->
    <div class="page-header">
        <div class="header-content">
            <h1>Offres d'emploi</h1>
            <p class="header-description">Découvrez les dernières opportunités professionnelles</p>
        </div>
        <div class="header-stats">
            <span class="jobs-count-badge">
                <i class="fas fa-briefcase"></i>
                <?= $totalJobs ?? 0 ?> offres disponibles
            </span>
        </div>
    </div>

    <!-- Barre de recherche avancée -->
    <div class="search-advanced">
        <form method="GET" action="index.php" class="search-form">
            <input type="hidden" name="action" value="jobs">
            
            <div class="search-grid">
                <div class="search-field">
                    <label><i class="fas fa-search"></i> Mots-clés</label>
                    <input type="text" 
                           name="keyword" 
                           placeholder="Titre du poste, compétences..." 
                           value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>"
                           class="search-input">
                </div>
                
                <div class="search-field">
                    <label><i class="fas fa-tag"></i> Type de contrat</label>
                    <select name="type" class="search-select">
                        <option value="">Tous les contrats</option>
                        <option value="CDI" <?= ($filters['type'] ?? '') == 'CDI' ? 'selected' : '' ?>>CDI</option>
                        <option value="Stage" <?= ($filters['type'] ?? '') == 'Stage' ? 'selected' : '' ?>>Stage</option>
                        <option value="Alternance" <?= ($filters['type'] ?? '') == 'Alternance' ? 'selected' : '' ?>>Alternance</option>
                        <option value="CDD" <?= ($filters['type'] ?? '') == 'CDD' ? 'selected' : '' ?>>CDD</option>
                    </select>
                </div>
                
                <div class="search-field">
                    <label><i class="fas fa-map-marker-alt"></i> Ville</label>
                    <input type="text" 
                           name="city" 
                           placeholder="Tunis, Sfax, Sousse..." 
                           value="<?= htmlspecialchars($filters['city'] ?? '') ?>"
                           class="search-input">
                </div>
                
                <div class="search-action">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i>
                        Rechercher
                    </button>
                    <?php if (!empty($filters['keyword']) || !empty($filters['type']) || !empty($filters['city'])): ?>
                        <a href="?action=jobs" class="btn-reset">
                            <i class="fas fa-times"></i>
                            Réinitialiser
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Résultats de recherche -->
    <?php if (!empty($filters['keyword']) || !empty($filters['type']) || !empty($filters['city'])): ?>
        <div class="search-results-info">
            <i class="fas fa-filter"></i>
            Résultats pour :
            <?php if (!empty($filters['keyword'])): ?>
                <span class="filter-tag">"<?= htmlspecialchars($filters['keyword']) ?>"</span>
            <?php endif; ?>
            <?php if (!empty($filters['type'])): ?>
                <span class="filter-tag"><?= htmlspecialchars($filters['type']) ?></span>
            <?php endif; ?>
            <?php if (!empty($filters['city'])): ?>
                <span class="filter-tag"><?= htmlspecialchars($filters['city']) ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Grille d'offres -->
    <?php if (!empty($jobs)): ?>
        <div class="jobs-grid">
            <?php foreach($jobs as $job): ?>
            <a href="?action=job&id=<?= $job['id'] ?>" class="job-card-link">
                <div class="job-card <?= isset($job['featured']) && $job['featured'] ? 'featured' : '' ?>">
                    <?php if(isset($job['featured']) && $job['featured']): ?>
                        <div class="job-badge">
                            <i class="fas fa-star"></i>
                            À la une
                        </div>
                    <?php endif; ?>
                    
                    <div class="job-header">
                        <div class="company-logo">
                            <div class="logo-placeholder">
                                <?= strtoupper(substr($job['company_name'] ?? 'E', 0, 1)) ?>
                            </div>
                        </div>
                        <div class="job-header-info">
                            <h3 class="job-title"><?= htmlspecialchars($job['title']) ?></h3>
                            <div class="company-name">
                                <i class="fas fa-building"></i>
                                <?= htmlspecialchars($job['company_name'] ?? 'Entreprise') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="job-details">
                        <div class="job-detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($job['city'] ?? 'Non spécifié') ?></span>
                        </div>
                        <div class="job-detail-item">
                            <i class="fas fa-clock"></i>
                            <span><?= htmlspecialchars($job['type'] ?? 'CDI') ?></span>
                        </div>
                        <div class="job-detail-item">
                            <i class="far fa-calendar-alt"></i>
                            <span>Publié le <?= date('d/m/Y', strtotime($job['created_at'])) ?></span>
                        </div>
                        <?php if(!empty($job['deadline'])): ?>
                        <div class="job-detail-item deadline">
                            <i class="fas fa-hourglass-end"></i>
                            <span>Limite: <?= date('d/m/Y', strtotime($job['deadline'])) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="job-description">
                        <p><?= htmlspecialchars(substr($job['description'] ?? '', 0, 150)) ?>...</p>
                    </div>
                    
                    <div class="job-footer">
                        <div class="job-type-badge">
                            <?= htmlspecialchars($job['type'] ?? 'CDI') ?>
                        </div>
                        <?php if(!empty($job['salary'])): ?>
                            <div class="job-salary">
                                <i class="fas fa-money-bill-wave"></i>
                                <?= htmlspecialchars($job['salary']) ?>
                            </div>
                        <?php endif; ?>
                        <div class="job-view">
                            Voir l'offre
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-results-container">
            <div class="no-results-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>Aucune offre trouvée</h3>
            <p>Essayez de modifier vos critères de recherche ou consultez toutes nos offres.</p>
            <a href="?action=jobs" class="btn-reset-all">
                <i class="fas fa-redo-alt"></i>
                Voir toutes les offres
            </a>
        </div>
    <?php endif; ?>
</div>