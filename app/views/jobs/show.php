<div class="job-detail-page">
    <div class="container">
        <!-- Fil d'Ariane (Breadcrumb) -->
        <div class="breadcrumb">
            <a href="?action=home">Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <a href="?action=jobs">Offres d'emploi</a>
            <i class="fas fa-chevron-right"></i>
            <span><?= htmlspecialchars($data['job']['title']) ?></span>
        </div>

        <!-- En-tête de l'offre -->
        <div class="job-header-card">
            <div class="job-header-content">
                <div class="company-logo-large">
                    <div class="logo-placeholder-large">
                        <?= strtoupper(substr($data['job']['company_name'] ?? $data['company']['name'] ?? 'E', 0, 1)) ?>
                    </div>
                </div>
                <div class="job-header-info">
                    <h1><?= htmlspecialchars($data['job']['title']) ?></h1>
                    <div class="company-name-large">
                        <i class="fas fa-building"></i>
                        <span><?= htmlspecialchars($data['job']['company_name'] ?? $data['company']['name'] ?? 'Entreprise') ?></span>
                    </div>
                    <div class="job-meta-large">
                        <span class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <?= htmlspecialchars($data['job']['city'] ?? 'Non spécifié') ?>
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            <?= htmlspecialchars($data['job']['type'] ?? 'CDI') ?>
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            Publié le <?= date('d/m/Y', strtotime($data['job']['created_at'])) ?>
                        </span>
                    </div>
                </div>
                <?php if(isset($data['job']['featured']) && $data['job']['featured']): ?>
                    <div class="featured-badge-large">
                        <i class="fas fa-star"></i>
                        Offre à la une
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="job-content-grid">
            <div class="job-main-content">
                <!-- Section Description -->
                <div class="content-section">
                    <h2><i class="fas fa-file-alt"></i> Description du poste</h2>
                    <div class="description-content">
                        <?= nl2br(htmlspecialchars($data['job']['description'] ?? '')) ?>
                    </div>
                </div>

                <!-- Section Compétences (si disponibles) -->
                <?php if(!empty($data['job']['skills'])): ?>
                <div class="content-section">
                    <h2><i class="fas fa-tools"></i> Compétences requises</h2>
                    <div class="skills-list">
                        <?php 
                        $skills = explode(',', $data['job']['skills']);
                        foreach($skills as $skill): 
                        ?>
                            <span class="skill-tag"><?= trim(htmlspecialchars($skill)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Section Missions (si disponibles) -->
                <?php if(!empty($data['job']['missions'])): ?>
                <div class="content-section">
                    <h2><i class="fas fa-tasks"></i> Missions</h2>
                    <div class="missions-list">
                        <?= nl2br(htmlspecialchars($data['job']['missions'] ?? '')) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Colonne de droite - Informations complémentaires -->
            <div class="job-sidebar">
                <!-- Carte des informations clés -->
                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Informations clés</h3>
                    
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-briefcase"></i> Type de contrat</span>
                        <span class="info-value"><?= htmlspecialchars($data['job']['type'] ?? 'Non spécifié') ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-map-marker-alt"></i> Lieu</span>
                        <span class="info-value"><?= htmlspecialchars($data['job']['city'] ?? 'Non spécifié') ?></span>
                    </div>

                    <?php if(!empty($data['job']['salary'])): ?>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-money-bill-wave"></i> Salaire</span>
                        <span class="info-value salary-value"><?= htmlspecialchars($data['job']['salary']) ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-calendar-plus"></i> Date de publication</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($data['job']['created_at'])) ?></span>
                    </div>

                    <?php if(!empty($data['job']['deadline'])): ?>
                    <div class="info-item deadline">
                        <span class="info-label"><i class="fas fa-hourglass-end"></i> Date limite</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($data['job']['deadline'])) ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Carte de l'entreprise -->
                <div class="company-card">
                    <h3><i class="fas fa-building"></i> À propos de l'entreprise</h3>
                    
                    <div class="company-details">
                        <div class="company-name-sidebar">
                            <i class="fas fa-building"></i>
                            <?= htmlspecialchars($data['job']['company_name'] ?? $data['company']['name'] ?? 'Entreprise') ?>
                        </div>
                        
                        <?php if(!empty($data['company']['description'])): ?>
                        <p class="company-description">
                            <?= htmlspecialchars($data['company']['description']) ?>
                        </p>
                        <?php endif; ?>
                        
                        <?php if(!empty($data['company']['website'])): ?>
                        <a href="<?= htmlspecialchars($data['company']['website']) ?>" target="_blank" class="company-website">
                            <i class="fas fa-globe"></i> Visiter le site web
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="action-card">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'candidate'): ?>
                        <!-- CORRECTION ICI : job_id au lieu de id -->
                        <a href="?action=apply&job_id=<?= $data['job']['id'] ?>" class="btn-apply">
                            <i class="fas fa-paper-plane"></i>
                            Postuler maintenant
                        </a>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $data['job']['recruiter_id']): ?>
                        <div class="recruiter-actions">
                            <a href="?action=editJob&id=<?= $data['job']['id'] ?>" class="btn-edit-job">
                                <i class="fas fa-edit"></i>
                                Modifier l'offre
                            </a>
                            <a href="?action=deleteJob&id=<?= $data['job']['id'] ?>" class="btn-delete-job" onclick="return confirm('Supprimer cette offre ?')">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <a href="?action=jobs" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Retour aux offres
                    </a>
                </div>
            </div>
        </div>

        <!-- Offres similaires (optionnel) -->
        <?php if(!empty($data['similarJobs'])): ?>
        <div class="similar-jobs-section">
            <h2>Offres similaires</h2>
            <div class="similar-jobs-grid">
                <?php foreach($data['similarJobs'] as $similar): ?>
                <a href="?action=job&id=<?= $similar['id'] ?>" class="similar-job-card">
                    <h4><?= htmlspecialchars($similar['title']) ?></h4>
                    <p><i class="fas fa-building"></i> <?= htmlspecialchars($similar['company_name']) ?></p>
                    <span class="similar-job-type"><?= htmlspecialchars($similar['type']) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>