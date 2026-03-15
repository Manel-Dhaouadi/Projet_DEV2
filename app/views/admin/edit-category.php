<div class="container">
    <div class="auth-card" style="max-width: 600px;">
        <div class="dashboard-header">
            <h1>Modifier la catégorie</h1>
            <a href="?action=admin-categories" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="category-name">Nom de la catégorie</label>
                <input type="text" 
                       id="category-name" 
                       name="name" 
                       value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                       required
                       autocomplete="off">
            </div>

            <div class="form-group">
                <label for="category-icon">Icône Font Awesome</label>
                <input type="text" 
                       id="category-icon" 
                       name="icon" 
                       value="<?= htmlspecialchars($category['icon'] ?? 'fa-folder') ?>"
                       autocomplete="off">
            </div>

            <div class="form-group">
                <label for="category-color">Couleur</label>
                <div class="color-input-group">
                    <input type="color" 
                           id="category-color" 
                           name="color" 
                           value="<?= htmlspecialchars($category['color'] ?? '#0a66c2') ?>"
                           style="width: 60px; height: 40px; padding: 0;">
                    <input type="text" 
                           name="color_text" 
                           value="<?= htmlspecialchars($category['color'] ?? '#0a66c2') ?>" 
                           style="flex: 1;"
                           onchange="document.getElementById('category-color').value = this.value">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="auth-btn">
                    <i class="fas fa-save"></i> Modifier la catégorie
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.color-input-group {
    display: flex;
    gap: 10px;
    align-items: center;
}
</style>