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
                        <th>CV</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['applications'] as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['candidate_name'] ?? $app['name'] ?? 'Candidat') ?></td>
                        <td><?= htmlspecialchars($app['email'] ?? 'Non renseigné') ?></td>
                        <td>
                            <?php if (!empty($app['cv'])): ?>
                                <a href="?action=download-ultra&id=<?= $app['id'] ?>" class="btn-icon download" title="Télécharger CV">
                                    <i class="fas fa-download"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Non fourni</span>
                            <?php endif; ?>
                        </td>
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
                            <!-- BOUTON SUPPRIMER AVEC PARAMÈTRE from=applications -->
                            <a href="?action=deleteApplication&id=<?= $app['id'] ?>&from=applications" 
                               class="btn-icon delete" 
                               title="Supprimer"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette candidature ?')">
                                <i class="fas fa-trash"></i>
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

<style>
.btn-icon.download {
    color: #0a66c2;
}
.btn-icon.download:hover {
    background: #e6f0fa;
    color: #004182;
}
.text-muted {
    color: #9ca3af;
    font-style: italic;
    font-size: 0.85rem;
}
.applications-table-container {
    overflow-x: auto;
    margin: 2rem 0;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.applications-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    min-width: 800px;
}
.applications-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 1rem;
    text-align: left;
    text-transform: uppercase;
    border-bottom: 2px solid #e2e8f0;
}
.applications-table td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}
.applications-table tbody tr:hover {
    background: #f8fafc;
}
.status-badge {
    display: inline-block;
    padding: 0.3rem 1rem;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
}
.status-badge.pending {
    background: #fff4e5;
    color: #b65700;
}
.status-badge.accepted {
    background: #e3f3e9;
    color: #0a5e2e;
}
.status-badge.rejected {
    background: #ffe5e5;
    color: #b30000;
}
.actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s;
    background: white;
    border: 1px solid #e2e8f0;
}
.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.btn-icon.accept:hover {
    background: #10b981;
    color: white;
    border-color: #10b981;
}
.btn-icon.reject:hover {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
}
.btn-icon.delete:hover {
    background: #dc2626;
    color: white;
    border-color: #dc2626;
}
</style>