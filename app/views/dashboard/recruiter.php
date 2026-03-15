

<div class="recruiter-dashboard">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header">
        <div class="header-title">
            <h1>
                <i class="fas fa-briefcase"></i> 
                Espace Recruteur
            </h1>
            <p class="welcome-text">Bienvenue, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Recruteur') ?> 👋</p>
        </div>
        <div class="header-actions">
            <a href="?action=createJob" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Publier une offre
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalJobs'] ?? 0 ?></div>
                <div class="stat-label">Offres publiées</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalApplications'] ?? 0 ?></div>
                <div class="stat-label">Candidatures reçues</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['pendingApplications'] ?? 0 ?></div>
                <div class="stat-label">En attente</div>
            </div>
        </div>
    </div>

    <!-- Liste des offres -->
    <div class="jobs-section">
        <div class="section-header">
            <h2><i class="fas fa-briefcase"></i> Mes offres d'emploi</h2>
            <a href="?action=createJob" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Nouvelle offre
            </a>
        </div>

        <?php if (!empty($jobs) && is_array($jobs)): ?>
            <div class="table-responsive">
                <table class="jobs-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Ville</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Candidatures</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                        <?php if (is_array($job) && isset($job['id'])): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($job['title'] ?? 'Sans titre') ?></strong>
                                <?php if(!empty($job['featured'])): ?>
                                    <span class="featured-badge">À la une</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="job-type">
                                    <?= htmlspecialchars($job['type'] ?? 'Non spécifié') ?>
                                </span>
                            </td>
                            <td>
                                <i class="fas fa-map-marker-alt"></i> 
                                <?= htmlspecialchars($job['city'] ?? 'Non spécifié') ?>
                            </td>
                            <td>
                                <?php 
                                if (isset($job['created_at']) && !empty($job['created_at'])) {
                                    // S'assurer que la date est bien formatée
                                    $date = new DateTime($job['created_at']);
                                    echo $date->format('d/m/Y');
                                } else {
                                    echo 'Date inconnue';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                $today = date('Y-m-d');
                                $deadline = $job['deadline'] ?? '';
                                if(!empty($deadline) && $deadline < $today): 
                                ?>
                                    <span class="status-badge expired">Expirée</span>
                                <?php else: ?>
                                    <span class="status-badge active">Active</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="applications-count">
                                    <?= isset($job['applications_count']) ? $job['applications_count'] : 0 ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="?action=editJob&id=<?= $job['id'] ?>" class="btn-icon edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=applications&job_id=<?= $job['id'] ?>" class="btn-icon view" title="Candidatures">
                                    <i class="fas fa-users"></i>
                                </a>
                                <a href="?action=deleteJob&id=<?= $job['id'] ?>" 
                                   class="btn-icon delete" 
                                   title="Supprimer"
                                   onclick="return confirm('Supprimer cette offre ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-briefcase"></i>
                <h3>Aucune offre publiée</h3>
                <p>Commencez par publier votre première offre d'emploi</p>
                <a href="?action=createJob" class="btn btn-primary">Publier une offre</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Dernières candidatures -->
    <?php if (!empty($applications) && is_array($applications)): ?>
    <div class="applications-section">
        <h2><i class="fas fa-file-signature"></i> Dernières candidatures</h2>
        
        <?php 
        $count = 0;
        foreach ($applications as $app): 
            if ($count >= 5) break;
            if (is_array($app) && isset($app['id'])):
        ?>
        <div class="application-item">
            <div class="candidate-info">
                <div class="candidate-avatar">
                    <?= isset($app['candidate_name']) ? strtoupper(substr($app['candidate_name'], 0, 1)) : 'C' ?>
                </div>
                <div>
                    <strong><?= htmlspecialchars($app['candidate_name'] ?? 'Candidat') ?></strong>
                    <small><?= htmlspecialchars($app['job_title'] ?? 'Offre') ?></small>
                </div>
            </div>
            <div class="application-date">
                <?= isset($app['created_at']) ? date('d/m/Y', strtotime($app['created_at'])) : 'Date inconnue' ?>
            </div>
            <div class="application-status">
                <span class="status-badge <?= $app['status'] ?? 'pending' ?>">
                    <?php 
                    $status = $app['status'] ?? 'pending';
                    if($status == 'pending') echo 'En attente';
                    elseif($status == 'accepted') echo 'Acceptée';
                    elseif($status == 'rejected') echo 'Refusée';
                    else echo 'En attente';
                    ?>
                </span>
            </div>
            <div class="application-actions">
                <a href="?action=viewApplication&id=<?= $app['id'] ?>" class="btn-icon" title="Voir">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        </div>
        <?php 
            $count++;
            endif;
        endforeach; 
        
        if ($count == 0):
        ?>
        <div class="application-item" style="justify-content: center; color: #5e5e5e; font-style: italic;">
            Aucune candidature pour le moment
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>