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
		<h2>Uusi vastaus</h2>
		<hr>
	</div>
		<form action="/answers/save" method="post">
			<div class="row">
				<div class="col-md-6 nopadding">
					<input type="hidden" name="id" value="<?= $id; ?>">
					<textarea name="vastaus" class="textarea input full-width"></textarea>
				</div>
			</div>
			<div class="row">
				<button type="submit" class="btn btn-md btn-primary">Tallenna</button>
			</div>
		</form>		
</div>
<?php
    require "_footer.view.php";