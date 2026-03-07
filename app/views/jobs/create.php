<div class="container">
    <div class="auth-card" style="max-width: 700px;">
        <h2>Publier une offre</h2>
        <p class="auth-subtitle">Remplissez les informations ci-dessous</p>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label>Titre du poste</label>
                <input type="text" name="title" required placeholder="ex: Développeur Full Stack">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="6" required placeholder="Décrivez le poste, les missions, le profil recherché..."></textarea>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Type de contrat</label>
                    <select name="type" required>
                        <option value="">Sélectionnez</option>
                        <option value="CDI">CDI</option>
                        <option value="Stage">Stage</option>
                        <option value="Alternance">Alternance</option>
                        <option value="CDD">CDD</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="category_id" required>
                        <option value="">Sélectionnez</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Ville</label>
                    <input type="text" name="city" required placeholder="ex: Tunis">
                </div>

                <div class="form-group">
                    <label>Salaire (optionnel)</label>
                    <input type="text" name="salary" placeholder="ex: 1500 DT">
                </div>
            </div>

            <div class="form-group">
                <label>Date limite</label>
                <input type="date" name="deadline" required min="<?= date('Y-m-d') ?>">
            </div>

            <button type="submit" class="auth-btn">
                <i class="fas fa-plus-circle"></i> Publier l'offre
            </button>
        </form>
    </div>
</div>