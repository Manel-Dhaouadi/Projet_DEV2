<div class="auth-container">
    <div class="auth-card">
        <h2>Inscription</h2>
        <p class="auth-subtitle">Rejoignez notre communauté professionnelle</p>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="register-name">Nom complet</label>
                <input type="text" 
                       id="register-name" 
                       name="name" 
                       placeholder="Jean Dupont" 
                       required
                       autocomplete="name">
            </div>
            
            <div class="form-group">
                <label for="register-email">Adresse email</label>
                <input type="email" 
                       id="register-email" 
                       name="email" 
                       placeholder="jean@email.com" 
                       required
                       autocomplete="email">
            </div>
            
            <div class="form-group">
                <label for="register-password">Mot de passe</label>
                <input type="password" 
                       id="register-password" 
                       name="password" 
                       placeholder="Min. 8 caractères" 
                       required
                       autocomplete="new-password">
                <div class="password-hint">Au moins 8 caractères</div>
            </div>
            
            <div class="form-group">
                <label for="register-city">Ville</label>
                <input type="text" 
                       id="register-city" 
                       name="city" 
                       placeholder="Tunis, Sfax, etc."
                       autocomplete="address-level2">
            </div>
            
            <div class="form-group">
                <label for="register-phone">Téléphone (optionnel)</label>
                <input type="tel" 
                       id="register-phone" 
                       name="phone" 
                       placeholder="+216 XX XXX XXX"
                       autocomplete="tel">
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