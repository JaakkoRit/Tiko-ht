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
	<h1>Luo uusi sessio</h1>
	<hr>
	<form action="/sessions-management/save" method="POST">

		<label class="label">Käyttäjien id:t</label>
		<input class="input" name="kayttajat" type="text">

		<label class="label">Tehtävälista</label>
		<input class="input" name="tehtavalista" type="text">

		<button type="submit" class="button is-primary">Tallenna</button>

	</form>
	<hr>
	<?php foreach ($students as $student) : ?>
		<li><?= "Opiskelijan id: $student->ID_KAYTTAJA, Nimi: $student->NIMI"; ?></li>
	<?php endforeach; ?>
	<hr>
	<?php foreach ($taskLists as $taskList) : ?>
		<li><?= "Tehtävälistan id: $taskList->ID_TLISTA, Kuvaus: $taskList->KUVAUS"; ?></li>
	<?php endforeach; ?>
</div>

<?php
    require "_footer.view.php";
