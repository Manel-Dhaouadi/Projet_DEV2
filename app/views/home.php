<div class="home-page">
    <!-- Bannière d'accueil -->
    <section class="welcome-banner">
        <div class="container">
            <div class="banner-content">
                <h1 class="banner-title">
                    Trouvez le job <span class="gradient-text">de vos rêves</span>
                </h1>
                <p class="banner-subtitle"><?= htmlspecialchars($metaDescription) ?></p>
                
                <!-- Barre de recherche améliorée -->
                <form action="index.php" method="GET" class="search-container">
                    <input type="hidden" name="action" value="jobs">
                    <div class="search-wrapper" style="box-shadow: 0 10px 25px rgba(10,102,194,0.15);">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" 
                                   id="search-keyword"
                                   name="keyword" 
                                   placeholder="Titre du poste, mots-clés..." 
                                   class="search-field"
                                   autocomplete="off">
                        </div>
                        <button type="submit" class="search-button" style="padding: 1rem 2.5rem;">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </form>

                <!-- Tags populaires améliorés -->
                <div class="tags-container" style="margin-top: 2rem;">
                    <span class="tags-label"><i class="fas fa-fire" style="color: #f59e0b; margin-right: 5px;"></i>Populaire :</span>
                    <a href="?action=jobs&type=CDI" class="tag-item" style="background: #e6f0fa; color: #0a66c2; border: none;">CDI</a>
                    <a href="?action=jobs&type=Stage" class="tag-item" style="background: #e3f3e9; color: #0a5e2e; border: none;">Stage</a>
                    <a href="?action=jobs&type=Alternance" class="tag-item" style="background: #fff4e5; color: #b65700; border: none;">Alternance</a>
                    <a href="?action=jobs&city=Tunis" class="tag-item" style="background: #e6f0fa; color: #0a66c2; border: none;">Tunis</a>
                    <a href="?action=jobs&city=Sfax" class="tag-item" style="background: #e6f0fa; color: #0a66c2; border: none;">Sfax</a>
                    <a href="?action=jobs&city=Sousse" class="tag-item" style="background: #e6f0fa; color: #0a66c2; border: none;">Sousse</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques améliorées -->
    <section class="stats-panel">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-block" style="border-left: 4px solid #0a66c2;">
                    <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="stat-content">
                        <div class="stat-number" style="font-size: 2.2rem;"><?= number_format($stats['jobs'] ?? 0) ?>+</div>
                        <div class="stat-label">Offres d'emploi</div>
                    </div>
                </div>
                
                <div class="stat-block" style="border-left: 4px solid #10b981;">
                    <div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #10b981;"><i class="fas fa-building"></i></div>
                    <div class="stat-content">
                        <div class="stat-number" style="font-size: 2.2rem;"><?= number_format($stats['companies'] ?? 2500) ?>+</div>
                        <div class="stat-label">Entreprises</div>
                    </div>
                </div>
                
                <div class="stat-block" style="border-left: 4px solid #f59e0b;">
                    <div class="stat-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;"><i class="fas fa-users"></i></div>
                    <div class="stat-content">
                        <div class="stat-number" style="font-size: 2.2rem;"><?= number_format($stats['candidates'] ?? 10000) ?>+</div>
                        <div class="stat-label">Candidats</div>
                    </div>
                </div>
                
                <div class="stat-block" style="border-left: 4px solid #8b5cf6;">
                    <div class="stat-icon" style="background: rgba(139,92,246,0.1); color: #8b5cf6;"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-content">
                        <div class="stat-number" style="font-size: 2.2rem;"><?= $stats['satisfaction'] ?? 98 ?>%</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Offres à la une améliorées -->
    <?php if (!empty($featuredJobs)): ?>
    <section class="featured-jobs-panel">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Offres <span class="gradient-text">à la une</span></h2>
                <p class="section-description">Découvrez les meilleures opportunités du moment</p>
            </div>

            <div class="jobs-featured-grid">
                <?php foreach ($featuredJobs as $index => $job): ?>
                <div class="job-featured-card" style="transform: translateY(<?= $index * 5 ?>px);">
                    <div class="featured-badge" style="background: linear-gradient(135deg, #0a66c2, #8b5cf6);">
                        <i class="fas fa-star"></i> À la une
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #0a66c2, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">
                            <?= strtoupper(substr($job['company_name'] ?? 'E', 0, 1)) ?>
                        </div>
                        <h3 class="job-title" style="margin-bottom: 0;"><?= htmlspecialchars($job['title']) ?></h3>
                    </div>
                    <div class="job-company-info">
                        <i class="fas fa-building"></i> <?= htmlspecialchars($job['company_name'] ?? 'Entreprise') ?>
                    </div>
                    <div class="job-details-list" style="display: flex; gap: 1rem; flex-wrap: wrap; margin: 1rem 0;">
                        <span style="background: #e6f0fa; color: #0a66c2; padding: 0.25rem 1rem; border-radius: 50px; font-size: 0.8rem;">
                            <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job['city'] ?? 'Non spécifié') ?>
                        </span>
                        <span style="background: #e3f3e9; color: #0a5e2e; padding: 0.25rem 1rem; border-radius: 50px; font-size: 0.8rem;">
                            <i class="fas fa-clock"></i> <?= htmlspecialchars($job['type'] ?? 'CDI') ?>
                        </span>
                    </div>
                    <p class="job-description-preview" style="color: #5e5e5e; line-height: 1.6;">
                        <?= htmlspecialchars(substr($job['description'] ?? '', 0, 120)) ?>...
                    </p>
                    <div class="job-card-footer">
                        <a href="?action=job&id=<?= $job['id'] ?>" class="job-view-link" style="color: #0a66c2; font-weight: 600;">
                            Voir l'offre <i class="fas fa-arrow-right"></i>
                        </a>
                        <?php if(!empty($job['salary'])): ?>
                            <span style="color: #10b981; font-weight: 600;"><i class="fas fa-money-bill-wave"></i> <?= htmlspecialchars($job['salary']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="section-footer">
                <a href="?action=jobs" class="btn-view-all" style="background: white; border: 2px solid #0a66c2; color: #0a66c2; padding: 1rem 3rem; border-radius: 50px; font-weight: 600; transition: all 0.3s;">
                    Voir toutes les offres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Comment ça marche amélioré -->
    <section class="how-it-works-panel">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Comment <span class="gradient-text">ça marche ?</span></h2>
                <p class="section-description">Trouvez votre prochain job en 3 étapes simples</p>
            </div>

            <div class="steps-container">
                <div class="step-item" style="border-top: 4px solid #0a66c2;">
                    <div class="step-number" style="background: #0a66c2;">1</div>
                    <div class="step-icon" style="background: rgba(10,102,194,0.1); color: #0a66c2;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3>Créez votre compte</h3>
                    <p style="color: #5e5e5e;">Inscrivez-vous gratuitement en quelques clics et créez votre profil professionnel</p>
                </div>
                
                <div class="step-item" style="border-top: 4px solid #10b981;">
                    <div class="step-number" style="background: #10b981;">2</div>
                    <div class="step-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Trouvez l'offre idéale</h3>
                    <p style="color: #5e5e5e;">Utilisez nos filtres avancés pour trouver les offres qui correspondent à vos critères</p>
                </div>
                
                <div class="step-item" style="border-top: 4px solid #f59e0b;">
                    <div class="step-number" style="background: #f59e0b;">3</div>
                    <div class="step-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h3>Postulez en 1 clic</h3>
                    <p style="color: #5e5e5e;">Envoyez votre candidature directement aux recruteurs et suivez son statut</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA amélioré -->
    <section class="cta-panel">
        <div class="container">
            <div class="cta-content">
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Prêt à commencer votre carrière ?</h2>
                <p style="font-size: 1.2rem; margin-bottom: 2.5rem;">Rejoignez des milliers de candidats qui ont déjà trouvé leur opportunité</p>
                <div class="cta-buttons">
                    <a href="?action=register&role=candidate" class="btn btn-primary" style="background: white; color: #0a66c2; padding: 1rem 2.5rem; border-radius: 50px; font-weight: 600;">
                        <i class="fas fa-user-plus"></i> S'inscrire
                    </a>
                    <a href="?action=register&role=recruiter" class="btn btn-outline" style="border: 2px solid white; color: white; padding: 1rem 2.5rem; border-radius: 50px; font-weight: 600;">
                        <i class="fas fa-building"></i> Publier une offre
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>