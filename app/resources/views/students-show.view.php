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
		<h1><?= $student->NIMI; ?></h1>
	</div>
	<div class="row">
		<div class="col-md-5 col-sm-12 nopadding">
			<ul class="list-group">
				<li class="list-group-item"><?= $student->ONRO; ?></li>
				<li class="list-group-item"><?= $student->PAAAINE; ?></li>
			</ul>
		</div>
	</div>
	<div class="row">
		<h2>Suoritetut sessiot</h2>
	</div>
	<div class="row">
		<?php foreach ($sessions as $session) : ?>
			<div class="col-md-5 col-sm-12 nopadding">
				<ul class="list-group">
					<li class="list-group-item">Sessio id: <p class="pull-right"><?= $session->ID_SESSIO; ?></p></li>
					<li class="list-group-item">Tehtävälista id: <p class="pull-right"><?= $session->ID_TLISTA; ?></p></li>
					<li class="list-group-item">Alkamisen ajankohta: <p class="pull-right"><?= $session->ALKAIKA; ?></p></li>
					<li class="list-group-item">Loppumisen ajankohta: <p class="pull-right"><?= $session->LOPAIKA; ?></p></li>
				</ul>
			</div>
			<div class="col-md-1">
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php
    require "_footer.view.php";