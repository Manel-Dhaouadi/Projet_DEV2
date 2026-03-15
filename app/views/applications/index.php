<!-- app/views/applications/index.php -->
<div class="applications-page">
    <div class="page-header">
        <h1><i class="fas fa-users"></i> Candidatures pour : <?= htmlspecialchars($data['job']['title']) ?></h1>
        <a href="?action=dashboard" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Retour au dashboard
        </a>
    </div>

    <?php if (!empty($data['applications'])): ?>
        <div class="applications-table-container">
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>Candidat</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['applications'] as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['name'] ?? $app['candidate_name'] ?? 'Candidat') ?></td>
                        <td><?= htmlspecialchars($app['email'] ?? 'Non renseigné') ?></td>
                        <td><?= date('d/m/Y', strtotime($app['created_at'])) ?></td>
                        <td>
                            <span class="status-badge <?= $app['status'] ?? 'pending' ?>">
                                <?php 
                                $status = $app['status'] ?? 'pending';
                                if($status == 'pending') echo 'En attente';
                                elseif($status == 'accepted') echo 'Acceptée';
                                elseif($status == 'rejected') echo 'Refusée';
                                ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="?action=updateStatus&id=<?= $app['id'] ?>&status=accepted&job_id=<?= $data['job']['id'] ?>" 
                               class="btn-icon accept" 
                               title="Accepter"
                               onclick="return confirm('Accepter cette candidature ?')">
                                <i class="fas fa-check"></i>
                            </a>
                            <a href="?action=updateStatus&id=<?= $app['id'] ?>&status=rejected&job_id=<?= $data['job']['id'] ?>" 
                               class="btn-icon reject" 
                               title="Refuser"
                               onclick="return confirm('Refuser cette candidature ?')">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Aucune candidature</h3>
            <p>Il n'y a pas encore de candidatures pour cette offre.</p>
            <a href="?action=dashboard" class="btn btn-primary">Retour au dashboard</a>
        </div>
    <?php endif; ?>
</div>