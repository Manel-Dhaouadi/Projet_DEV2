<div class="container">
    <div class="dashboard-header">
        <h1>Gestion des catégories</h1>
        <a href="?action=admin-add-category" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une catégorie
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Icône</th>
                    <th>Nom</th>
                    <th>Couleur</th>
                    <th>Offres</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td>#<?= $cat['id'] ?></td>
                    <td>
                        <div class="category-icon" style="background: <?= $cat['color'] ?>20; color: <?= $cat['color'] ?>; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas <?= $cat['icon'] ?>"></i>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td>
                        <span style="display: inline-block; width: 20px; height: 20px; background: <?= $cat['color'] ?>; border-radius: 4px;"></span>
                        <?= $cat['color'] ?>
                    </td>
                    <td>
                        <?php
                        $jobModel = new Job();
                        $count = $jobModel->count(['category_id' => $cat['id']]);
                        echo $count;
                        ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($cat['created_at'])) ?></td>
                    <td>
                        <a href="?action=admin-edit-category&id=<?= $cat['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?action=admin-delete-category&id=<?= $cat['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>