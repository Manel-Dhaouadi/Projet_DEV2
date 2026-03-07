<h2>Admin Panel</h2>

<h3>Utilisateurs</h3>

<table border="1">
<tr>
<th>ID</th>
<th>Nom</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php foreach($users as $user): ?>
<tr>
<td><?= $user['id'] ?></td>
<td><?= $user['name'] ?></td>
<td><?= $user['email'] ?></td>
<td><?= $user['role'] ?></td>
<td>
<a href="index.php?action=deleteUser&id=<?= $user['id'] ?>">
Supprimer
</a>
</td>
</tr>
<?php endforeach; ?>

</table>

<hr>

<h3>Offres</h3>

<table border="1">
<tr>
<th>ID</th>
<th>Titre</th>
<th>Ville</th>
<th>Action</th>
</tr>

<?php foreach($jobs as $job): ?>
<tr>
<td><?= $job['id'] ?></td>
<td><?= $job['title'] ?></td>
<td><?= $job['city'] ?></td>
<td>
<a href="index.php?action=deleteJobAdmin&id=<?= $job['id'] ?>">
Supprimer
</a>
</td>
</tr>
<?php endforeach; ?>

</table>