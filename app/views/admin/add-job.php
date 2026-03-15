<div class="container">
    <div class="auth-card" style="max-width: 700px;">
        <h2>Ajouter une offre d'emploi</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="title">Titre du poste</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       required 
                       placeholder="ex: Développeur Full Stack">
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="6" 
                          required 
                          placeholder="Décrivez le poste, les missions, le profil recherché..."></textarea>
            </div>
            
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="type">Type de contrat</label>
                    <select id="type" name="type" required>
                        <option value="">Sélectionnez</option>
                        <option value="CDI">CDI</option>
                        <option value="Stage">Stage</option>
                        <option value="Alternance">Alternance</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="recruiter_id">Recruteur</label>
                    <select id="recruiter_id" name="recruiter_id" required>
                        <option value="">Sélectionnez un recruteur</option>
                        <?php foreach ($recruiters as $recruiter): ?>
                            <option value="<?= $recruiter['id'] ?>">
                                <?= htmlspecialchars($recruiter['name']) ?> (<?= htmlspecialchars($recruiter['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="city">Ville</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           required 
                           placeholder="ex: Tunis">
                </div>
                
                <div class="form-group">
                    <label for="salary">Salaire (optionnel)</label>
                    <input type="text" 
                           id="salary" 
                           name="salary" 
                           placeholder="ex: 1500 DT">
                </div>
            </div>
            
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="deadline">Date limite</label>
                    <input type="date" 
                           id="deadline" 
                           name="deadline" 
                           required 
                           min="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="form-group">
                    <label for="featured">
                        <input type="checkbox" 
                               id="featured" 
                               name="featured" 
                               value="1">
                        Offre à la une
                    </label>
                </div>
            </div>
            
            <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Ajouter l'offre
                </button>
                <a href="?action=admin-dashboard" class="btn btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>