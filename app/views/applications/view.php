<!-- app/views/applications/view.php -->
<div class="application-detail-page">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-file-signature"></i> Détail de la candidature</h1>
            <a href="?action=applications&job_id=<?= $data['application']['job_id'] ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Retour aux candidatures
            </a>
        </div>

        <div class="application-detail-card">
            <div class="detail-section">
                <h2><i class="fas fa-user"></i> Informations du candidat</h2>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nom :</span>
                        <span class="detail-value"><?= htmlspecialchars($data['application']['candidate_name']) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email :</span>
                        <span class="detail-value"><?= htmlspecialchars($data['application']['email'] ?? 'Non renseigné') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Téléphone :</span>
                        <span class="detail-value"><?= htmlspecialchars($data['application']['phone'] ?? 'Non renseigné') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date de candidature :</span>
                        <span class="detail-value"><?= date('d/m/Y H:i', strtotime($data['application']['created_at'])) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Offre :</span>
                        <span class="detail-value"><?= htmlspecialchars($data['application']['job_title']) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Statut :</span>
                        <span class="detail-value">
                            <span class="status-badge <?= $data['application']['status'] ?>">
                                <?php 
                                if($data['application']['status'] == 'pending') echo 'En attente';
                                elseif($data['application']['status'] == 'accepted') echo 'Acceptée';
                                elseif($data['application']['status'] == 'rejected') echo 'Refusée';
                                ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.application-detail-page {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.page-header h1 {
    font-size: 2rem;
    color: #191919;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.page-header h1 i {
    color: #0a66c2;
    background: #e6f0fa;
    padding: 0.8rem;
    border-radius: 12px;
    font-size: 1.5rem;
}
.btn-back {
    background: transparent;
    border: 2px solid #e0e0e0;
    color: #5e5e5e;
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-back:hover {
    border-color: #0a66c2;
    color: #0a66c2;
    transform: translateX(-3px);
}
.application-detail-card {
    background: white;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #e0e0e0;
}
.detail-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
}
.detail-section h2 {
    font-size: 1.3rem;
    color: #191919;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.detail-section h2 i {
    color: #0a66c2;
}
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}
.detail-item {
    padding: 0.8rem;
    background: #f8fafc;
    border-radius: 8px;
}
.detail-label {
    font-weight: 600;
    color: #475569;
    display: block;
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
}
.detail-value {
    color: #191919;
    font-size: 1rem;
}
.status-badge {
    display: inline-block;
    padding: 0.3rem 1rem;
    border-radius: 40px;
    font-size: 0.8rem;
    font-weight: 600;
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
@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}
</style>