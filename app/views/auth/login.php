<div class="auth-container">
    <div class="auth-card">
        <h2>Connexion</h2>
        <p class="auth-subtitle">Accédez à votre espace personnel</p>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="login-email">Adresse email</label>
                <input type="email" 
                       id="login-email" 
                       name="email" 
                       placeholder="exemple@email.com" 
                       required
                       autocomplete="email">
            </div>
            
            <div class="form-group">
                <label for="login-password">Mot de passe</label>
                <input type="password" 
                       id="login-password" 
                       name="password" 
                       placeholder="••••••••" 
                       required
                       autocomplete="current-password">
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