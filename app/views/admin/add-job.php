<div class="form-page">
    <div class="form-container" style="max-width: 800px;">
        <div class="form-card">
            <div class="form-header">
                <div class="header-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h2>Publier une offre d'emploi</h2>
                <p class="header-subtitle">Remplissez les informations pour créer une nouvelle offre</p>
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
                        <label for="title">
                            <i class="fas fa-heading"></i>
                            Titre du poste <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               required 
                               placeholder="ex: Développeur Full Stack Senior"
                               autocomplete="off">
                        <span class="input-hint">Le titre doit être clair et attractif</span>
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="type">
                            <i class="fas fa-clock"></i>
                            Type de contrat <span class="required">*</span>
                        </label>
                        <select id="type" name="type" required>
                            <option value="" disabled selected>-- Sélectionnez --</option>
                            <option value="CDI">📄 CDI</option>
                            <option value="Stage">🎓 Stage</option>
                            <option value="Alternance">🔄 Alternance</option>
                            <option value="CDD">📅 CDD</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">
                            <i class="fas fa-map-marker-alt"></i>
                            Ville <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               required 
                               placeholder="ex: Tunis"
                               autocomplete="off">
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="recruiter_id">
                            <i class="fas fa-building"></i>
                            Recruteur <span class="required">*</span>
                        </label>
                        <select id="recruiter_id" name="recruiter_id" required>
                            <option value="" disabled selected>-- Choisir un recruteur --</option>
                            <?php if (!empty($recruiters)): ?>
                                <?php foreach ($recruiters as $recruiter): ?>
                                    <option value="<?= $recruiter['id'] ?>">
                                        <?= htmlspecialchars($recruiter['name']) ?> (<?= htmlspecialchars($recruiter['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Aucun recruteur disponible</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary">
                            <i class="fas fa-money-bill-wave"></i>
                            Salaire
                        </label>
                        <input type="text" 
                               id="salary" 
                               name="salary" 
                               placeholder="ex: 2500 DT"
                               autocomplete="off">
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="deadline">
                            <i class="fas fa-calendar-alt"></i>
                            Date limite <span class="required">*</span>
                        </label>
                        <input type="date" 
                               id="deadline" 
                               name="deadline" 
                               required 
                               min="<?= date('Y-m-d') ?>"
                               value="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" value="1">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                <i class="fas fa-star" style="color: #f59e0b;"></i>
                                Offre à la une
                            </span>
                        </label>
                        <span class="input-hint">Les offres à la une sont mises en avant</span>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-file-alt"></i>
                            Description du poste <span class="required">*</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="8" 
                                  required 
                                  placeholder="Décrivez le poste, les missions, le profil recherché, les avantages..."></textarea>
                        <span class="input-hint">Soyez précis et détaillé pour attirer les bons candidats</span>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus-circle"></i>
                        Publier l'offre
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