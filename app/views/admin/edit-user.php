<div class="form-page">
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h2>Modifier l'utilisateur</h2>
                <p class="header-subtitle">Modifiez les informations de l'utilisateur</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= $_SESSION['error'] ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" class="enhanced-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Nom complet <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?= htmlspecialchars($user['name']) ?>" 
                               required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Adresse email <span class="required">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?= htmlspecialchars($user['email']) ?>" 
                               required>
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="role">
                            <i class="fas fa-tag"></i>
                            Rôle <span class="required">*</span>
                        </label>
                        <select id="role" name="role" required>
                            <option value="candidate" <?= $user['role'] == 'candidate' ? 'selected' : '' ?>>👤 Candidat</option>
                            <option value="recruiter" <?= $user['role'] == 'recruiter' ? 'selected' : '' ?>>🏢 Recruteur</option>
                            <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>⚙️ Admin</option>
                            <?php endif; ?>
                        </select>
                        <?php if ($user['id'] == $_SESSION['user']['id']): ?>
                            <span class="input-hint text-warning">
                                <i class="fas fa-info-circle"></i>
                                Vous ne pouvez pas modifier votre propre rôle
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">
                            <i class="fas fa-map-marker-alt"></i>
                            Ville
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i>
                            Téléphone
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="form-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Le mot de passe ne peut pas être modifié depuis cette interface.</span>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Enregistrer les modifications
                    </button>
                    <a href="?action=admin-dashboard" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>