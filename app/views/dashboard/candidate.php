<div class="candidate-dashboard">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header">
        <div class="header-title">
            <h1>
                <i class="fas fa-user-graduate"></i> 
                Espace Candidat
            </h1>
            <p class="welcome-text">Bienvenue, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Candidat') ?> 👋</p>
        </div>
        <div class="header-actions">
            <a href="?action=jobs" class="btn btn-primary">
                <i class="fas fa-briefcase"></i> Voir les offres
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalApplications'] ?? 0 ?></div>
                <div class="stat-label">Candidatures</div>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['pending'] ?? 0 ?></div>
                <div class="stat-label">En attente</div>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['accepted'] ?? 0 ?></div>
                <div class="stat-label">Acceptées</div>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-icon purple">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['rejected'] ?? 0 ?></div>
                <div class="stat-label">Refusées</div>
            </div>
        </div>
    </div>

    <!-- Filtres rapides -->
    <div class="quick-filters">
        <a href="?action=dashboard" class="filter-chip <?= !isset($_GET['status']) ? 'active' : '' ?>">
            <i class="fas fa-list"></i> Toutes
        </a>
        <a href="?action=dashboard&status=pending" class="filter-chip <?= ($_GET['status'] ?? '') == 'pending' ? 'active' : '' ?>">
            <i class="fas fa-clock"></i> En attente
        </a>
        <a href="?action=dashboard&status=accepted" class="filter-chip <?= ($_GET['status'] ?? '') == 'accepted' ? 'active' : '' ?>">
            <i class="fas fa-check-circle"></i> Acceptées
        </a>
        <a href="?action=dashboard&status=rejected" class="filter-chip <?= ($_GET['status'] ?? '') == 'rejected' ? 'active' : '' ?>">
            <i class="fas fa-times-circle"></i> Refusées
        </a>
    </div>

    <!-- Mes candidatures -->
    <div class="applications-section">
        <div class="section-header">
            <h2><i class="fas fa-file-signature"></i> Mes candidatures</h2>
            <a href="?action=myApplications" class="btn btn-sm btn-outline">
                Voir tout <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <?php if (!empty($applications)): ?>
            <?php 
            // Filtrer les candidatures selon le statut sélectionné
            $filteredApps = $applications;
            if (isset($_GET['status'])) {
                $filteredApps = array_filter($applications, function($app) {
                    return $app['status'] == $_GET['status'];
                });
            }
            $displayApps = array_slice($filteredApps, 0, 3);
            ?>
            <?php if (!empty($displayApps)): ?>
                <div class="applications-list">
                    <?php foreach ($displayApps as $app): ?>
                    <div class="application-item">
                        <div class="job-info">
                            <div class="job-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="job-details">
                                <span class="job-title"><?= htmlspecialchars($app['title']) ?></span>
                                <span class="company-name">
                                    <i class="fas fa-building"></i>
                                    <?= htmlspecialchars($app['company_name'] ?? 'Entreprise') ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="job-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($app['city'] ?? 'N/A') ?></span>
                            <span><i class="fas fa-clock"></i> <?= date('d/m/Y', strtotime($app['created_at'])) ?></span>
                        </div>
                        
                        <div class="application-status">
                            <span class="status-badge <?= $app['status'] ?>">
                                <?php 
                                if($app['status'] == 'pending') echo 'En attente';
                                elseif($app['status'] == 'accepted') echo 'Acceptée';
                                elseif($app['status'] == 'rejected') echo 'Refusée';
                                ?>
                            </span>
                        </div>
                        
                        <div class="application-actions">
                            <a href="?action=job&id=<?= $app['job_id'] ?>" class="btn-view">
                                Voir <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (count($filteredApps) > 3): ?>
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="?action=myApplications<?= isset($_GET['status']) ? '&status='.$_GET['status'] : '' ?>" class="btn btn-sm btn-outline">
                        Voir les <?= count($filteredApps) - 3 ?> autres candidatures
                    </a>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state" style="padding: 2rem;">
                    <i class="fas fa-file-signature" style="font-size: 3rem;"></i>
                    <h3>Aucune candidature avec ce statut</h3>
                    <a href="?action=dashboard" class="btn btn-primary">Voir toutes les candidatures</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state" style="padding: 2rem;">
                <i class="fas fa-file-signature" style="font-size: 3rem;"></i>
                <h3>Aucune candidature</h3>
                <p>Vous n'avez pas encore postulé à des offres</p>
                <a href="?action=jobs" class="btn btn-primary">Voir les offres</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Offres récentes -->
    <div class="recommended-section">
        <div class="section-header">
            <h2><i class="fas fa-clock"></i> Offres récentes</h2>
            <a href="?action=jobs" class="btn btn-sm btn-outline">
                Voir tout <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <?php if (!empty($recentJobs)): ?>
        <div class="recommended-grid">
            <?php foreach (array_slice($recentJobs, 0, 3) as $job): ?>
            <div class="recommended-card">
                <h3><?= htmlspecialchars($job['title']) ?></h3>
                <div class="recommended-company">
                    <i class="fas fa-building"></i> <?= htmlspecialchars($job['company_name'] ?? 'Entreprise') ?>
                </div>
                <div class="recommended-meta">
                    <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job['city'] ?? 'N/A') ?></span>
                    <span><i class="fas fa-briefcase"></i> <?= htmlspecialchars($job['type'] ?? 'CDI') ?></span>
                </div>
                <div class="recommended-footer">
                    <a href="?action=job&id=<?= $job['id'] ?>" class="btn-view" style="width: 100%; justify-content: center;">
                        Voir l'offre <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state" style="padding: 2rem;">
            <p>Aucune offre disponible pour le moment</p>
        </div>
        <?php endif; ?>
    </div>
</div>