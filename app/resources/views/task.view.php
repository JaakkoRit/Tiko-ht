<?php require "_header.view.php"; ?>

<?php if(strlen($message) > 0): ?>
<div class="notification is-primary">
	<?= $message; ?>
</div>
<?php endif; ?>

<nav class="panel">
	<p class="panel-heading">
		Tehtävälista
	</p>

	<?php foreach ($tasks as $task):?>
		<label class="panel-block">
			<input
				type="checkbox"
				disabled="disabled"
				<?php if($task->isCompleted()) { echo ' checked="checked"'; } ?>
			>
				<?= htmlspecialchars($task->description); ?>
				<?php if(!$task->isCompleted()): ?>
					- [<a href="/tasks/?action=merkkaa&id=<?= $task->id; ?>">Merkkaa valmiiksi</a>]
				<?php endif; ?>
				- [<a href="/tasks/?action=poista&id=<?= $task->id; ?>">Poista</a>] - <span class="tag is-primary"><?= htmlspecialchars($task->duedate); ?></span>
		</label>
	<?php endforeach;?>
</nav>

<h1 class="title">Lisää uusi tehtävä</h1>

<div class="notification">
	<form action="/tasks" method="POST">
		<label class="label" for="description">Anna kuvaus</label>
		<p class="control">
			<input class="input" type="text" id="description" name="description">
		</p>

		<label class="label" for="duedate">Anna määräaika</label>
		<p class="control">
			<input class="input" type="text" id="duedate" name="duedate">
		</p>

        <input type="hidden" name="token" value="<?= $token; ?>">

		<p class="control">
			<input class="button is-primary" type="submit" value="Lisää uusi tehtävä">
		</p>
	</form>
</div>
<?php require "_footer.view.php"; ?>