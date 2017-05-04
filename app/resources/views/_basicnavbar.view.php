<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1">
				<a class="navbar-brand" href="#">SQL-opetus</a>
			</div>
			<?php if (isset($_SESSION['nimi'])) : ?>
				<p class="navbar-text"><?php echo $_SESSION['nimi']; ?></p>
			<?php endif; ?>
		</div>
	</div>
</nav>
<div class="content">