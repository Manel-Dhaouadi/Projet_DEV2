<div class="dashboard-page">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header">
        <div class="header-title">
            <h1>
                <i class="fas fa-tachometer-alt"></i> 
                Dashboard Administrateur
            </h1>
            <p class="welcome-text">Bienvenue, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?> 👋</p>
        </div>
        <div class="header-actions">
            <a href="?action=admin-add-user" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Ajouter un utilisateur
            </a>
            <a href="?action=admin-add-job" class="btn btn-success" style="margin-left: 10px;">
                <i class="fas fa-briefcase"></i> Ajouter une offre
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
                <div class="stat-value"><?= number_format($stats['totalUsers'] ?? 0) ?></div>
                <div class="stat-label">Utilisateurs totaux</div>
            </div>
        </div>

        <div class="stat-card gradient-green">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['totalJobs'] ?? 0) ?></div>
                <div class="stat-label">Offres d'emploi</div>
            </div>
        </div>

        <div class="stat-card gradient-orange">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['totalRecruiters'] ?? 0) ?></div>
                <div class="stat-label">Recruteurs</div>
            </div>
        </div>

        <div class="stat-card gradient-purple">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?= number_format($stats['totalCandidates'] ?? 0) ?></div>
                <div class="stat-label">Candidats</div>
            </div>
        </div>
    </div>

    <!-- Graphique de répartition -->
    <div style="display: flex; justify-content: center; margin: 2rem 0;">
        <div class="analytics-card" style="width: 100%; max-width: 600px;">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Répartition des utilisateurs</h3>
                <span class="badge">Cette semaine</span>
            </div>
            <div class="card-body">
                <div class="pie-chart-container">
                    <?php 
                    $totalUsers = $stats['totalUsers'] ?? 1;
                    $candidates = $stats['totalCandidates'] ?? 0;
                    $recruiters = $stats['totalRecruiters'] ?? 0;
                    $admins = $totalUsers - $candidates - $recruiters;
                    
                    // Calculer les pourcentages
                    $candPercent = $totalUsers > 0 ? round(($candidates / $totalUsers) * 100) : 0;
                    $recPercent = $totalUsers > 0 ? round(($recruiters / $totalUsers) * 100) : 0;
                    $adminPercent = $totalUsers > 0 ? round(($admins / $totalUsers) * 100) : 0;
                    ?>
                    
                    <div class="pie-chart" style="background: conic-gradient(#0a66c2 0% <?= $candPercent ?>%, #10b981 <?= $candPercent ?>% <?= $candPercent + $recPercent ?>%, #f59e0b <?= $candPercent + $recPercent ?>% 100%);"></div>
                    
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="color-dot" style="background: #0a66c2;"></span>
                            <span>Candidats (<?= number_format($candidates) ?>)</span>
                        </div>
                        <div class="legend-item">
                            <span class="color-dot" style="background: #10b981;"></span>
                            <span>Recruteurs (<?= number_format($recruiters) ?>)</span>
                        </div>
                        <div class="legend-item">
                            <span class="color-dot" style="background: #f59e0b;"></span>
                            <span>Admins (<?= number_format($admins) ?>)</span>
                        </div>
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
                <i class="fas fa-briefcase"></i> Offres
            </button>
        </div>

        <!-- Tab: Utilisateurs -->
        <div id="users-tab" class="tab-content active">
            <div class="table-container">
                <div class="table-header">
                    <h3>Liste des utilisateurs (<?= count($users ?? []) ?>)</h3>
                    <div class="table-actions">
                        <input type="text" placeholder="Rechercher..." class="search-input" id="searchUsers">
                        <a href="?action=admin-add-user" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Ajouter
                        </a>
                    </div>
                </div>
                
                <?php if (!empty($users)): ?>
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
                                    <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                        <a href="?action=admin-edit-user&id=<?= $user['id'] ?>" 
                                           class="btn-icon edit" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=deleteUser&id=<?= $user['id'] ?>" 
                                           class="btn-icon delete" 
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="btn-icon disabled" title="Vous ne pouvez pas vous modifier ou supprimer">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="no-data">Aucun utilisateur trouvé</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab: Offres -->
        <div id="jobs-tab" class="tab-content">
            <div class="table-container">
                <div class="table-header">
                    <h3>Liste des offres (<?= count($jobs ?? []) ?>)</h3>
                    <div class="table-actions">
                        <a href="?action=admin-add-job" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Ajouter une offre
                        </a>
                        <a href="?action=jobs" class="btn btn-sm btn-outline">Voir toutes les offres</a>
                    </div>
                </div>
                
                <?php if (!empty($jobs)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Recruteur</th>
                            <th>Type</th>
                            <th>Ville</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td>#<?= $job['id'] ?></td>
                            <td><?= htmlspecialchars($job['title']) ?></td>
                            <td><?= htmlspecialchars($job['company_name'] ?? 'N/A') ?></td>
                            <td><span class="job-type"><?= $job['type'] ?? 'CDI' ?></span></td>
                            <td><?= htmlspecialchars($job['city'] ?? 'N/A') ?></td>
                            <td><?= date('d/m/Y', strtotime($job['created_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="?action=admin-edit-job&id=<?= $job['id'] ?>" 
                                       class="btn-icon edit" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?action=deleteJobAdmin&id=<?= $job['id'] ?>" 
                                       class="btn-icon delete" 
                                       title="Supprimer"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="no-data">Aucune offre trouvée</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour les onglets -->
<script>
function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById(tabId).classList.add('active');
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