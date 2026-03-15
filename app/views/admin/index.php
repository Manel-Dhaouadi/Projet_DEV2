<h2>Admin Panel</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<h3>Utilisateurs</h3>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach($users as $user): ?>
            <tr>
                <td>#<?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <span class="role-badge role-<?= $user['role'] ?>">
                        <?= ucfirst($user['role']) ?>
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                            <a href="?action=admin-edit-user&id=<?= $user['id'] ?>" 
                               class="btn-edit" 
                               title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="?action=deleteUser&id=<?= $user['id'] ?>" 
                               class="btn-delete"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                               title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Impossible</span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Aucun utilisateur trouvé</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<hr>

<h3>Offres d'emploi</h3>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Recruteur</th>
            <th>Type</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($jobs)): ?>
            <?php foreach($jobs as $job): ?>
            <tr>
                <td>#<?= $job['id'] ?></td>
                <td><?= htmlspecialchars($job['title']) ?></td>
                <td><?= htmlspecialchars($job['company_name'] ?? 'N/A') ?></td>
                <td><span class="job-type"><?= $job['type'] ?? 'CDI' ?></span></td>
                <td><?= htmlspecialchars($job['city'] ?? 'N/A') ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="?action=admin-edit-job&id=<?= $job['id'] ?>" 
                           class="btn-edit" 
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?action=deleteJobAdmin&id=<?= $job['id'] ?>" 
                           class="btn-delete"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')"
                           title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Aucune offre trouvée</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>