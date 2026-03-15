<div class="container">
    <div class="auth-card">
        <h2>Modifier l'offre</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <input type="hidden" name="id" value="<?= $job['id'] ?>">

            <div class="form-group">
                <label for="title">Titre du poste</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($job['title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="6" required><?= htmlspecialchars($job['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="type">Type de contrat</label>
                <select id="type" name="type" required>
                    <option value="CDI" <?= $job['type'] == 'CDI' ? 'selected' : '' ?>>CDI</option>
                    <option value="Stage" <?= $job['type'] == 'Stage' ? 'selected' : '' ?>>Stage</option>
                    <option value="Alternance" <?= $job['type'] == 'Alternance' ? 'selected' : '' ?>>Alternance</option>
                </select>
            </div>

            <div class="form-group">
                <label for="city">Ville</label>
                <input type="text" id="city" name="city" value="<?= htmlspecialchars($job['city']) ?>" required>
            </div>

            <div class="form-group">
                <label for="deadline">Date limite</label>
                <input type="date" id="deadline" name="deadline" value="<?= $job['deadline'] ?>" required>
            </div>

            <div class="form-group">
                <label for="salary">Salaire (optionnel)</label>
                <input type="text" id="salary" name="salary" value="<?= htmlspecialchars($job['salary'] ?? '') ?>" placeholder="ex: 1500 DT">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href="?action=jobs" class="btn btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>