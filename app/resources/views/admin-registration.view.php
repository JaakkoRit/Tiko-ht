<?php require "_header.view.php"; ?>
<?php require "_basicnavbar.view.php"; ?>
<div class="container login-container">
	<div class="row login">
		<div class="col-md-4 col-md-offset-4">
			<form action="/admin-registration" method="POST">
				<h2>Ylläpitäjän rekisteröinti</h2>
				<div class="form-group">
					<label>Ylläpitäjän nimi</label>
					<input class="input form-control" name="nimi" type="text" placeholder="Nimi" required autofocus>
				</div>
				<div class="form-group">
					<label>Salasana</label>
					<input class="input form-control" name="salasana" type="password" required>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-primary">Rekisteröi</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    require "message.view.php";
    require "errors.view.php";
    require "_footer.view.php";