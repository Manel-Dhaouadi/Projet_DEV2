<div class="auth-container">
    <div class="auth-card">
        <h2>Connexion</h2>
        <p class="auth-subtitle">Accédez à votre espace personnel</p>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="exemple@email.com" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="auth-btn">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Pas encore de compte ? <a href="?action=register">Inscrivez-vous</a></p>
        </div>
    </div>
</div>