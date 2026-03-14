<h2><?= htmlspecialchars($job['title']) ?></h2>

<p><strong>Entreprise:</strong> <?= htmlspecialchars($company['name']) ?></p>
<p><strong>Type:</strong> <?= $job['type'] ?></p>
<p><strong>Ville:</strong> <?= htmlspecialchars($job['city']) ?></p>
<p><strong>Date limite:</strong> <?= date('d/m/Y', strtotime($job['deadline'])) ?></p>

<?php if (!empty($job['salary'])): ?>
    <p><strong>Salaire:</strong> <?= htmlspecialchars($job['salary']) ?></p>
<?php endif; ?>

<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

<div class="job-actions">
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'candidate'): ?>
        <a href="?action=apply&id=<?= $job['id'] ?>" class="btn">Postuler</a>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $job['recruiter_id']): ?>
        <a href="?action=editJob&id=<?= $job['id'] ?>" class="btn">Modifier</a>
        <a href="?action=deleteJob&id=<?= $job['id'] ?>" class="btn" onclick="return confirm('Supprimer ?')">Supprimer</a>
    <?php endif; ?>
    
    <a href="?action=jobs" class="btn">Retour</a>
</div>