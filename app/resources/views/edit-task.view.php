<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>
<div class="container page-content">
	<?php
		require 'message.view.php';
		require 'errors.view.php';
	?>
	<div class="row">
		<h2>Muokkaa tehtävää</h2>
		<hr>
	</div>
	<form action="/tasks/update" method="post">
		<div class="row">
			<div class="col-md-6 nopadding">
				<input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="id">	
				<h3>Tehtävän kuvaus</h3>
				<textarea name="kuvaus" class="textarea input full-width"><?= $task->KUVAUS; ?></textarea>
			</div>
		</div>
		<div class="row">
			<h3>Vastaukset</h3>
		</div>
		<div class="row">
			<?php $index = 0; foreach ($answers as $answer) : ?>
				<div class="col-md-5 col-sm-12 nopadding bottom-margin">
					<input type="hidden" name="alkuperainen<?= $index; ?>" value="<?= $answer->VASTAUS; ?>">
					<textarea name="vastaus" class="textarea input full-width"><?= $answer->VASTAUS; ?></textarea>
					<a href="/answers/delete?index=<?= $index; ?>&id=<?= $task->ID_TEHTAVA; ?>"class="btn btn-sm btn-danger pull-left">Poista</a>
				</div>
				<div class="col-md-1">
				</div>
				<?php $index += 1; ?>
			<?php endforeach; ?>
		</div>
		<div class="row">
			<br>
			<a href="/answers/create?id=<?= $task->ID_TEHTAVA; ?>" class="btn btn-sm btn-primary">Lisää vastaus</a>
		</div>
		<div class="row">
			<hr>
			<button type="submit" class="btn btn-md btn-primary">Tallenna</button>
			<a href="<?= getReferer(); ?>" class="btn btn-md btn-default">Takaisin</a>
		</div>
	</form>
</div>
<?php
    require "_footer.view.php";