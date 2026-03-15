<div class="form-page">
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2>Ajouter un utilisateur</h2>
                <p class="header-subtitle">Créez un nouveau compte utilisateur sur la plateforme</p>
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
                               required 
                               placeholder="Jean Dupont"
                               autocomplete="off">
                        <span class="input-hint">Le nom complet de l'utilisateur</span>
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
                               required 
                               placeholder="jean@exemple.com"
                               autocomplete="off">
                        <span class="input-hint">L'email sera utilisé pour la connexion</span>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Mot de passe <span class="required">*</span>
                        </label>
                        <div class="password-input-wrapper">
                            <input type="text" 
                                   id="password" 
                                   name="password" 
                                   value="123456"
                                   required>
                            <button type="button" class="password-toggle" onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="input-hint">Par défaut: 123456 (l'utilisateur pourra le changer)</span>
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="role">
                            <i class="fas fa-tag"></i>
                            Rôle <span class="required">*</span>
                        </label>
                        <select id="role" name="role" required>
                            <option value="" disabled selected>-- Sélectionnez un rôle --</option>
                            <option value="candidate">👤 Candidat</option>
                            <option value="recruiter">🏢 Recruteur</option>
                            <option value="admin">⚙️ Administrateur</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">
                            <i class="fas fa-map-marker-alt"></i>
                            Ville
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               placeholder="Tunis, Sfax, etc."
                               autocomplete="off">
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
                               placeholder="+216 XX XXX XXX"
                               autocomplete="off">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Ajouter l'utilisateur
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