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
		<h2>Kaikki oppilaat</h2>
	</div>
	<div class="row">
		<div class="col-md-5 col-sm-12 nopadding">
		<ul class="list-group scroll-list bordered-list">
			<?php foreach ($students as $student) : ?>
				<li class="list-group-item">
					<?= $student->NIMI; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		</div>
	</div>
	<div class="row">
		<h2>Oppilaat, jotka ovat suorittaneet sessiosi</h2>
	</div>
	<div class="row">
		<div class="col-md-5 col-sm-12 nopadding">
			<ul class="list-group scroll-list bordered-list">
				<?php foreach ($sessionStudents as $student) : ?>
					<li class="list-group-item list-form-item">
						<form action="/students/show" method="post">
							<?= $student->NIMI; ?>
							<input type="hidden" name="id" value="<?= $student->ID_KAYTTAJA; ?>">
							<button type="submit" class="btn btn-sm btn-info pull-right">Tarkastele</button>
						</form>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php
	require "_footer.view.php";