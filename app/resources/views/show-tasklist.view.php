<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>
<div class="container page-content">
	<?php
		require 'message.view.php';
	?>
	<div class="row">
		<h1>Tehtävälistan tehtävät</h1>
		<hr>
	</div>
	<div class="row">
		<div class="col-md-6 nopadding">
			<ul class="list-group">
				<?php foreach ($tasks as $task) : ?>
					<li class="list-group-item"><?= $task->KUVAUS; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="row">
		<?php if (auth()->ID_KAYTTAJA == $taskListCreator || \App\App\Models\Gate::hasRole('admin')) : ?>
			<form action="/tasklists/delete" method="post">
				<input type="hidden" name="id" value="<?= $id ?>">
				<div class="col-md-3 col-sm-6 pull-left nopadding">
					<a href="/edit-tasklist?id=<?= $id; ?>" class="btn btn-md btn-primary">Muokkaa listaa</a>
				</div>
				<div class="col-md-3 col-sm-6 nopadding">
					<button type="submit" class="btn btn-md btn-danger pull-right">Poista lista</button>
				</div>
			</form>
		<?php endif; ?>
	</div>
	<br>
</div>
<?php
    require "_footer.view.php";