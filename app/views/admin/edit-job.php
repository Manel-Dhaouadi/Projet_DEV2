<div class="container">
    <div class="auth-card" style="max-width: 700px;">
        <h2>Modifier l'offre</h2>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label>Titre</label>
                <input type="text" name="title" value="<?= htmlspecialchars($job['title']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="6" required><?= htmlspecialchars($job['description']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="CDI" <?= $job['type'] == 'CDI' ? 'selected' : '' ?>>CDI</option>
                    <option value="Stage" <?= $job['type'] == 'Stage' ? 'selected' : '' ?>>Stage</option>
                    <option value="Alternance" <?= $job['type'] == 'Alternance' ? 'selected' : '' ?>>Alternance</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Ville</label>
                <input type="text" name="city" value="<?= htmlspecialchars($job['city']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Salaire</label>
                <input type="text" name="salary" value="<?= htmlspecialchars($job['salary'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label>Date limite</label>
                <input type="date" name="deadline" value="<?= $job['deadline'] ?>" required>
            </div>
            
            <button type="submit" class="auth-btn">Modifier</button>
            <a href="?action=admin" class="btn btn-outline" style="margin-top: 1rem; display: block; text-align: center;">Retour</a>
        </form>
    </div>
</div>