<div class="container">
    <div class="auth-card">
        <h2>Publier une offre</h2>
        <p class="auth-subtitle">Remplissez les informations ci-dessous</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="job-title">Titre du poste</label>
                <input type="text" id="job-title" name="title" required placeholder="ex: Développeur Full Stack" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="job-description">Description</label>
                <textarea id="job-description" name="description" rows="6" required placeholder="Décrivez le poste, les missions, le profil recherché..." autocomplete="off"></textarea>
            </div>

            <div class="form-group">
                <label for="job-type">Type de contrat</label>
                <select id="job-type" name="type" required>
                    <option value="">Sélectionnez</option>
                    <option value="CDI">CDI</option>
                    <option value="Stage">Stage</option>
                    <option value="Alternance">Alternance</option>
                </select>
            </div>

            <div class="form-group">
                <label for="job-city">Ville</label>
                <input type="text" id="job-city" name="city" required placeholder="ex: Tunis" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="job-salary">Salaire (optionnel)</label>
                <input type="text" id="job-salary" name="salary" placeholder="ex: 1500 DT" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="job-deadline">Date limite</label>
                <input type="date" id="job-deadline" name="deadline" required min="<?= date('Y-m-d') ?>" autocomplete="off">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Publier l'offre
                </button>
                <a href="?action=dashboard" class="btn btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>