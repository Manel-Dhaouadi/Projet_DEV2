<h2>Modifier Offre</h2>

<form method="POST">

<input type="hidden" name="id" value="<?= $job['id'] ?>">

<input type="text" name="title" value="<?= $job['title'] ?>">
<textarea name="description"><?= $job['description'] ?></textarea>

<select name="type">
<option value="CDI">CDI</option>
<option value="Stage">Stage</option>
<option value="Alternance">Alternance</option>
</select>

<input type="text" name="city" value="<?= $job['city'] ?>">
<input type="date" name="deadline" value="<?= $job['deadline'] ?>">

<button type="submit">Update</button>

</form>