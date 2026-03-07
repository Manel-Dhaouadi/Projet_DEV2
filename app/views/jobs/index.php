<div class="jobs-header">
    <h1>Offres d'emploi</h1>
    <span class="jobs-count"><?= $totalJobs ?? 0 ?> offres disponibles</span>
</div>

<div class="filters-bar">
    <div class="filter-group">
        <label>Mots-clés</label>
        <input type="text" placeholder="Titre, compétences..." value="<?= $_GET['keyword'] ?? '' ?>">
    </div>
    
    <div class="filter-group">
        <label>Type de contrat</label>
        <select>
            <option value="">Tous</option>
            <option value="CDI">CDI</option>
            <option value="Stage">Stage</option>
            <option value="Alternance">Alternance</option>
            <option value="CDD">CDD</option>
        </select>
    </div>
    
    <div class="filter-group">
        <label>Ville</label>
        <input type="text" placeholder="Paris, Lyon, etc.">
    </div>
    
    <button class="filter-btn">
        <i class="fas fa-search"></i> Rechercher
    </button>
</div>

<div class="jobs-grid">
    <?php foreach($jobs as $job): ?>
    <div class="job-card <?= $job['featured'] ? 'featured' : '' ?>">
        <h3><?= htmlspecialchars($job['title']) ?></h3>
        
        <div class="job-company">
            <i class="fas fa-building"></i>
            <?= htmlspecialchars($job['company']) ?>
        </div>
        
        <div class="job-tags">
            <span class="job-tag"><?= htmlspecialchars($job['type']) ?></span>
            <span class="job-tag"><?= htmlspecialchars($job['city']) ?></span>
        </div>
        
        <div class="job-meta">
            <span><i class="far fa-clock"></i> <?= date('d/m/Y', strtotime($job['created_at'])) ?></span>
            <span><i class="far fa-calendar-alt"></i> <?= $job['deadline'] ?></span>
        </div>
        
        <div class="job-footer">
            <span class="job-type"><?= htmlspecialchars($job['type']) ?></span>
            <?php if($job['salary']): ?>
                <span class="job-salary"><?= $job['salary'] ?> DT</span>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="pagination">
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">5</a>
</div>