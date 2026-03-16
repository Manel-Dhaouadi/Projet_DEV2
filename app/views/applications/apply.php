<!-- app/views/applications/apply.php -->
<div class="apply-page">
    <div class="apply-container">
        <div class="apply-header">
            <h1><i class="fas fa-paper-plane"></i> Postuler à l'offre</h1>
            <a href="?action=job&id=<?= $data['job']['id'] ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <div class="apply-card">
            <div class="job-summary">
                <h2><?= htmlspecialchars($data['job']['title']) ?></h2>
                <p class="company">
                    <i class="fas fa-building"></i> <?= htmlspecialchars($data['job']['company_name'] ?? 'Entreprise') ?>
                </p>
                <div class="job-details-mini">
                    <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($data['job']['city'] ?? 'N/A') ?></span>
                    <span><i class="fas fa-briefcase"></i> <?= htmlspecialchars($data['job']['type'] ?? 'CDI') ?></span>
                </div>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="?action=apply&job_id=<?= $data['job']['id'] ?>" method="POST" enctype="multipart/form-data" class="apply-form">
                
                <!-- Option 1: Lien texte (optionnel) -->
                <div class="form-group">
                    <label for="cv_link">
                        <i class="fas fa-link"></i> Lien vers votre CV (Google Drive, LinkedIn)
                    </label>
                    <input 
                        type="url" 
                        name="cv_link" 
                        id="cv_link" 
                        class="form-input"
                        placeholder="https://..."
                    >
                </div>

                <div class="form-divider">
                    <span>OU</span>
                </div>

                <!-- Option 2: Upload de fichier PDF -->
                <div class="form-group">
                    <label for="cv_file">
                        <i class="fas fa-file-pdf"></i> Uploader votre CV (PDF uniquement)
                    </label>
                    <div class="file-upload">
                        <input 
                            type="file" 
                            name="cv_file" 
                            id="cv_file" 
                            accept=".pdf,application/pdf"
                            class="file-input"
                        >
                        <label for="cv_file" class="file-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Choisir un fichier PDF
                        </label>
                        <span class="file-name" id="file-name">Aucun fichier choisi</span>
                    </div>
                    <small class="form-hint">Taille maximale: 5 Mo. Format accepté: PDF</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Envoyer ma candidature
                    </button>
                    <a href="?action=job&id=<?= $data['job']['id'] ?>" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.apply-page {
    background: linear-gradient(135deg, #f6f8fa 0%, #f0f2f5 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.apply-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.apply-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.apply-header h1 {
    font-size: 2rem;
    color: #191919;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.apply-header h1 i {
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

.apply-card {
    background: white;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #e0e0e0;
}

.job-summary {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e0e0e0;
}

.job-summary h2 {
    font-size: 1.3rem;
    color: #191919;
    margin-bottom: 0.5rem;
}

.job-summary .company {
    color: #5e5e5e;
    font-size: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.job-summary .company i {
    color: #0a66c2;
}

.job-details-mini {
    display: flex;
    gap: 1.5rem;
    color: #5e5e5e;
    font-size: 0.9rem;
    flex-wrap: wrap;
}

.job-details-mini span {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.job-details-mini i {
    color: #0a66c2;
}

.error-message {
    background: #fee2e2;
    color: #dc2626;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border-left: 4px solid #dc2626;
}

.apply-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-weight: 600;
    color: #191919;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group label i {
    color: #0a66c2;
}

.form-input {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #0a66c2;
    box-shadow: 0 0 0 4px rgba(10,102,194,0.1);
}

.form-divider {
    text-align: center;
    margin: 1rem 0;
    position: relative;
}

.form-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e0e0e0;
    z-index: 1;
}

.form-divider span {
    background: white;
    padding: 0 1rem;
    color: #5e5e5e;
    font-size: 0.9rem;
    position: relative;
    z-index: 2;
}

.file-upload {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.file-input {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.file-label {
    background: linear-gradient(135deg, #0a66c2, #2563eb);
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.file-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(10,102,194,0.3);
}

.file-name {
    color: #5e5e5e;
    font-size: 0.9rem;
}

.form-hint {
    font-size: 0.8rem;
    color: #5e5e5e;
    margin-top: 0.3rem;
    display: block;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-submit {
    flex: 2;
    background: linear-gradient(135deg, #0a66c2, #2563eb);
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(10,102,194,0.3);
}

.btn-cancel {
    flex: 1;
    background: #f8fafc;
    color: #5e5e5e;
    padding: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-cancel:hover {
    background: #fee2e2;
    border-color: #dc2626;
    color: #dc2626;
}

@media (max-width: 640px) {
    .apply-header {
        flex-direction: column;
        text-align: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .job-details-mini {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<script>
// Afficher le nom du fichier sélectionné
document.getElementById('cv_file').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : 'Aucun fichier choisi';
    document.getElementById('file-name').textContent = fileName;
});
</script>