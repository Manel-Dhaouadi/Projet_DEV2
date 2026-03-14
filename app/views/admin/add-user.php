<div class="container">
    <div class="auth-card" style="max-width: 600px;">
        <h2>Ajouter un utilisateur</h2>
        
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
                       required 
                       placeholder="Jean Dupont">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       required 
                       placeholder="jean@email.com">
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe (par défaut: 123456)</label>
                <input type="text" 
                       id="password" 
                       name="password" 
                       value="123456"
                       placeholder="Laissez 123456 par défaut">
                <small class="text-muted">L'utilisateur pourra changer son mot de passe plus tard</small>
            </div>
            
            <div class="form-group">
                <label for="role">Rôle</label>
                <select id="role" name="role" required>
                    <option value="candidate">Candidat</option>
                    <option value="recruiter">Recruteur</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="city">Ville</label>
                <input type="text" 
                       id="city" 
                       name="city" 
                       placeholder="Tunis, Sfax, etc.">
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone</label>
                <input type="text" 
                       id="phone" 
                       name="phone" 
                       placeholder="+216 XX XXX XXX">
            </div>
            
            <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Ajouter
                </button>
                <a href="?action=admin" class="btn btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>