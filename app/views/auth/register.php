<div class="auth-container">
    <div class="auth-card">
        <h2>Inscription</h2>
        <p class="auth-subtitle">Rejoignez notre communauté professionnelle</p>
        
        <form method="POST" class="auth-form">
            <div class="role-selector">
                <label class="role-option">
                    <input type="radio" name="role" value="candidate" checked>
                    <i class="fas fa-user-graduate"></i>
                    <span>Candidat</span>
                </label>
                
                <label class="role-option">
                    <input type="radio" name="role" value="recruiter">
                    <i class="fas fa-building"></i>
                    <span>Recruteur</span>
                </label>
            </div>
            
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" placeholder="Jean Dupont" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="jean@email.com" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="Min. 8 caractères" required>
                <div class="password-hint">Au moins 8 caractères</div>
            </div>
            
            <div class="form-group">
                <label>Ville</label>
                <input type="text" name="city" placeholder="Tunis, Sfax, etc.">
            </div>
            
            <button type="submit" class="auth-btn">
                <i class="fas fa-user-plus"></i> S'inscrire
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Déjà inscrit ? <a href="?action=login">Connectez-vous</a></p>
        </div>
    </div>
</div>