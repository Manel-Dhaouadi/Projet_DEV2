<!-- app/views/applications/myApplications.php -->
<div class="my-applications-page">
    <div class="page-header">
        <h1><i class="fas fa-file-signature"></i> Mes Candidatures</h1>
        <a href="?action=jobs" class="btn btn-outline">
            <i class="fas fa-briefcase"></i> Voir les offres
        </a>
    </div>

    <?php if (!empty($data['apps'])): ?>
        <div class="applications-grid">
            <?php foreach($data['apps'] as $app): ?>
                <div class="application-card">
                    <div class="application-card-header">
                        <h3><?= htmlspecialchars($app['title']) ?></h3>
                        <span class="company-name">
                            <i class="fas fa-building"></i> 
                            <?= htmlspecialchars($app['company_name'] ?? 'Entreprise') ?>
                        </span>
                    </div>
                    
                    <div class="application-card-body">
                        <div class="application-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($app['city'] ?? 'Non spécifié') ?></span>
                        </div>
                        <div class="application-detail">
                            <i class="fas fa-clock"></i>
                            <span>Postulé le: <?= date('d/m/Y', strtotime($app['created_at'])) ?></span>
                        </div>
                        <div class="application-detail">
                            <i class="fas fa-tag"></i>
                            <span><?= htmlspecialchars($app['type'] ?? 'CDI') ?></span>
                        </div>
                    </div>
                    
                    <div class="application-card-footer">
                        <span class="status-badge <?= $app['status'] ?>">
                            <?php 
                            $status = $app['status'] ?? 'pending';
                            if($status == 'pending') echo 'En attente';
                            elseif($status == 'accepted') echo 'Acceptée';
                            elseif($status == 'rejected') echo 'Refusée';
                            ?>
                        </span>
                        <a href="?action=job&id=<?= $app['job_id'] ?>" class="btn-view">
                            Voir l'offre <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-file-signature"></i>
            <h3>Aucune candidature</h3>
            <p>Vous n'avez pas encore postulé à des offres.</p>
            <a href="?action=jobs" class="btn btn-primary">
                <i class="fas fa-briefcase"></i> Parcourir les offres
            </a>
        </div>
    <?php endif; ?>
</div>