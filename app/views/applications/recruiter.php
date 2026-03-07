<h2>Candidatures reçues</h2>

<a href="index.php?action=exportPDF">📄 Export PDF</a>

<?php foreach($apps as $app): ?>

<h3><?= $app['name'] ?> - <?= $app['title'] ?></h3>
<p>Status: <?= $app['status'] ?></p>

<a href="index.php?action=updateStatus&id=<?= $app['id'] ?>&status=accepted">
Accepter</a>

<a href="index.php?action=updateStatus&id=<?= $app['id'] ?>&status=rejected">
Refuser</a>

<hr>

<?php endforeach; ?>