<div class="dashboard-page">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header">
        <div class="header-title">
            <h1>
                <i class="fas fa-tachometer-alt"></i> 
                Dashboard Administrateur
            </h1>
            <p class="welcome-text">Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?> 👋</p>
        </div>
        <div class="header-actions">
            <a href="?action=admin-categories" class="btn btn-primary">
                <i class="fas fa-tags"></i> Gérer les catégories
            </a>
            <a href="?action=admin-users" class="btn btn-outline">
                <i class="fas fa-users"></i> Gérer les utilisateurs
            </a>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="stats-cards">
        <div class="stat-card gradient-blue">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalUsers'] ?? 0 ?></div>
                <div class="stat-label">Utilisateurs totaux</div>
                <div class="stat-trend">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> +12%
                    </span>
                    vs mois dernier
                </div>
            </div>
        </div>

        <div class="stat-card gradient-green">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalJobs'] ?? 0 ?></div>
                <div class="stat-label">Offres d'emploi</div>
                <div class="stat-trend">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> +8%
                    </span>
                    vs mois dernier
                </div>
            </div>
        </div>

        <div class="stat-card gradient-orange">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalRecruiters'] ?? 0 ?></div>
                <div class="stat-label">Recruteurs</div>
                <div class="stat-trend">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> +15%
                    </span>
                    vs mois dernier
                </div>
            </div>
        </div>

        <div class="stat-card gradient-purple">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['totalCandidates'] ?? 0 ?></div>
                <div class="stat-label">Candidats</div>
                <div class="stat-trend">
                    <span class="trend-up">
                        <i class="fas fa-arrow-up"></i> +10%
                    </span>
                    vs mois dernier
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et analyses -->
    <div class="analytics-section">
        <div class="analytics-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Répartition des utilisateurs</h3>
                <span class="badge">Cette semaine</span>
            </div>
            <div class="card-body">
                <div class="pie-chart-container">
                    <!-- Graphique circulaire simple avec CSS -->
                    <div class="pie-chart" style="background: conic-gradient(#0a66c2 0% 40%, #10b981 40% 70%, #f59e0b 70% 85%, #8b5cf6 85% 100%);"></div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="color-dot" style="background: #0a66c2;"></span>
                            <span>Candidats (<?= $stats['totalCandidates'] ?? 0 ?>)</span>
                        </div>
                        <div class="legend-item">
                            <span class="color-dot" style="background: #10b981;"></span>
                            <span>Recruteurs (<?= $stats['totalRecruiters'] ?? 0 ?>)</span>
                        </div>
                        <div class="legend-item">
                            <span class="color-dot" style="background: #f59e0b;"></span>
                            <span>Admins (<?= ($stats['totalUsers'] ?? 0) - ($stats['totalCandidates'] ?? 0) - ($stats['totalRecruiters'] ?? 0) ?>)</span>
                        </div>
                        <div class="legend-item">
                            <span class="color-dot" style="background: #8b5cf6;"></span>
                            <span>Inactifs (0)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="analytics-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-line"></i> Évolution des inscriptions</h3>
                <span class="badge">30 derniers jours</span>
            </div>
            <div class="card-body">
                <div class="bar-chart">
                    <!-- Simulation de barres de progression -->
                    <div class="bar-item">
                        <span class="bar-label">Semaine 1</span>
                        <div class="bar-progress">
                            <div class="bar-fill" style="width: 75%;"></div>
                        </div>
                        <span class="bar-value">45</span>
                    </div>
                    <div class="bar-item">
                        <span class="bar-label">Semaine 2</span>
                        <div class="bar-progress">
                            <div class="bar-fill" style="width: 82%;"></div>
                        </div>
                        <span class="bar-value">52</span>
                    </div>
                    <div class="bar-item">
                        <span class="bar-label">Semaine 3</span>
                        <div class="bar-progress">
                            <div class="bar-fill" style="width: 68%;"></div>
                        </div>
                        <span class="bar-value">38</span>
                    </div>
                    <div class="bar-item">
                        <span class="bar-label">Semaine 4</span>
                        <div class="bar-progress">
                            <div class="bar-fill" style="width: 91%;"></div>
                        </div>
                        <span class="bar-value">67</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections avec onglets -->
    <div class="tabs-section">
        <div class="tabs-header">
            <button class="tab-btn active" onclick="showTab('users-tab')">
                <i class="fas fa-users"></i> Utilisateurs
            </button>
            <button class="tab-btn" onclick="showTab('jobs-tab')">
                <i class="fas fa-briefcase"></i> Offres récentes
            </button>
            <button class="tab-btn" onclick="showTab('activity-tab')">
                <i class="fas fa-history"></i> Activité récente
            </button>
        </div>

        <!-- Tab: Utilisateurs -->
        <div id="users-tab" class="tab-content active">
            <div class="table-container">
                <div class="table-header">
                    <h3>Liste des utilisateurs</h3>
                    <div class="table-actions">
                        <input type="text" placeholder="Rechercher..." class="search-input" id="searchUsers">
                        <a href="?action=admin-create-user" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Ajouter
                        </a>
                    </div>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Ville</th>
                            <th>Inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>#<?= $user['id'] ?></td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                    <span><?= htmlspecialchars($user['name']) ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="role-badge role-<?= $user['role'] ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($user['city'] ?? 'Non spécifié') ?></td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?action=admin-edit-user&id=<?= $user['id'] ?>" class="btn-icon" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?action=admin-delete-user&id=<?= $user['id'] ?>" 
                                       class="btn-icon delete" 
                                       title="Supprimer"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Offres récentes -->
        <div id="jobs-tab" class="tab-content">
            <div class="table-container">
                <div class="table-header">
                    <h3>Dernières offres publiées</h3>
                    <a href="?action=jobs" class="btn btn-sm btn-outline">Voir toutes les offres</a>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Recruteur</th>
                            <th>Type</th>
                            <th>Ville</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($jobs ?? [], 0, 5) as $job): ?>
                        <tr>
                            <td><?= htmlspecialchars($job['title']) ?></td>
                            <td><?= htmlspecialchars($job['company_name'] ?? 'N/A') ?></td>
                            <td><span class="job-type"><?= $job['type'] ?? 'CDI' ?></span></td>
                            <td><?= htmlspecialchars($job['city'] ?? 'N/A') ?></td>
                            <td><?= date('d/m/Y', strtotime($job['created_at'])) ?></td>
                            <td>
                                <span class="status-badge status-<?= $job['featured'] ? 'active' : 'pending' ?>">
                                    <?= $job['featured'] ? 'Active' : 'En attente' ?>
                                </span>
                            </td>
                            <td>
                                <a href="?action=admin-edit-job&id=<?= $job['id'] ?>" class="btn-icon">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Activité récente -->
        <div id="activity-tab" class="tab-content">
            <div class="activity-feed">
                <div class="activity-item">
                    <div class="activity-icon" style="background: #e6f0fa; color: #0a66c2;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>Nouvel utilisateur</strong> - Marie Ben Ali s'est inscrite comme candidat</p>
                        <span class="activity-time">Il y a 5 minutes</span>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon" style="background: #e6f7e6; color: #10b981;">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>Nouvelle offre</strong> - Tech Solutions a publié une offre "Développeur Full Stack"</p>
                        <span class="activity-time">Il y a 2 heures</span>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon" style="background: #fff4e6; color: #f59e0b;">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>Nouvelle candidature</strong> - Ahmed Karray a postulé à l'offre "Commercial B2B"</p>
                        <span class="activity-time">Il y a 3 heures</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour les onglets -->
<script>
function showTab(tabId) {
    // Cacher tous les tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Désactiver tous les boutons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Afficher le tab sélectionné
    document.getElementById(tabId).classList.add('active');
    
    // Activer le bouton correspondant
    event.target.classList.add('active');
}

// Recherche en temps réel
document.getElementById('searchUsers')?.addEventListener('keyup', function() {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll('#users-tab tbody tr');
    
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>