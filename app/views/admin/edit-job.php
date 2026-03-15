<div class="form-page">
    <div class="form-container" style="max-width: 800px;">
        <div class="form-card">
            <div class="form-header">
                <div class="header-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h2>Modifier l'offre d'emploi</h2>
                <p class="header-subtitle">Modifiez les informations de l'offre</p>
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
                               value="<?= htmlspecialchars($job['title']) ?>" 
                               required>
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="type">
                            <i class="fas fa-clock"></i>
                            Type de contrat <span class="required">*</span>
                        </label>
                        <select id="type" name="type" required>
                            <option value="CDI" <?= $job['type'] == 'CDI' ? 'selected' : '' ?>>📄 CDI</option>
                            <option value="Stage" <?= $job['type'] == 'Stage' ? 'selected' : '' ?>>🎓 Stage</option>
                            <option value="Alternance" <?= $job['type'] == 'Alternance' ? 'selected' : '' ?>>🔄 Alternance</option>
                            <option value="CDD" <?= $job['type'] == 'CDD' ? 'selected' : '' ?>>📅 CDD</option>
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
                               value="<?= htmlspecialchars($job['city']) ?>" 
                               required>
                    </div>
                </div>
                
                <div class="form-row dual-column">
                    <div class="form-group">
                        <label for="salary">
                            <i class="fas fa-money-bill-wave"></i>
                            Salaire
                        </label>
                        <input type="text" 
                               id="salary" 
                               name="salary" 
                               value="<?= htmlspecialchars($job['salary'] ?? '') ?>"
                               placeholder="ex: 2500 DT">
                    </div>
                    
                    <div class="form-group">
                        <label for="deadline">
                            <i class="fas fa-calendar-alt"></i>
                            Date limite <span class="required">*</span>
                        </label>
                        <input type="date" 
                               id="deadline" 
                               name="deadline" 
                               value="<?= $job['deadline'] ?>" 
                               required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" value="1" <?= isset($job['featured']) && $job['featured'] ? 'checked' : '' ?>>
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                <i class="fas fa-star" style="color: #f59e0b;"></i>
                                Offre à la une
                            </span>
                        </label>
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
                                  required><?= htmlspecialchars($job['description']) ?></textarea>
                    </div>
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