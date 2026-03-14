<div class="container">
    <div class="auth-card" style="max-width: 600px;">
        <h2>Modifier l'utilisateur</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($user['name']) ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?= htmlspecialchars($user['email']) ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="role">Rôle</label>
                <select id="role" name="role" required>
                    <option value="candidate" <?= $user['role'] == 'candidate' ? 'selected' : '' ?>>Candidat</option>
                    <option value="recruiter" <?= $user['role'] == 'recruiter' ? 'selected' : '' ?>>Recruteur</option>
                    <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <?php endif; ?>
                </select>
                <?php if ($user['id'] == $_SESSION['user']['id']): ?>
                    <small class="text-muted">Vous ne pouvez pas changer votre propre rôle</small>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="city">Ville</label>
                <input type="text" 
                       id="city" 
                       name="city" 
                       value="<?= htmlspecialchars($user['city'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="text" 
                       id="phone" 
                       name="phone" 
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            
            <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="?action=admin" class="btn btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>