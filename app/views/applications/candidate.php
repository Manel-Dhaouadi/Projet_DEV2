<h2>Mes Candidatures</h2>

<?php foreach($apps as $app): ?>

<h3><?= $app['title'] ?></h3>
<p>Status: <?= $app['status'] ?></p>
<p>Date: <?= $app['created_at'] ?></p>

<hr>

<?php endforeach; ?>