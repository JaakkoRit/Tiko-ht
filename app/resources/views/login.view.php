<?php require '_basicnavbar.view.php'; ?>
<div class="container login-container">
	<?php
		require 'message.view.php';
		require 'errors.view.php';
	?>
	<div class="row login">
		<div class="col-md-4 col-md-offset-4">
			<div class="text-center" id="login-selection">
				<h4>Valitse kirjautumisen tyyppi</h4>
				<button type="button" class="btn btn-primary btn-block" onclick="openLogin('studentForm')">Opiskelija</button>
				<button type="button" class="btn btn-success btn-block" onclick="openLogin('teacherForm')">Opettaja</button>
				<button type="button" class="btn btn-warning btn-block" onclick="openLogin('adminForm')">Ylläpito</button>
			</div>
			<div id="login" style="display: none;">
				<form action="/student-login" method="POST" class="form-signin" id="studentForm" style="display: none;">
					<h2>Opiskelijan kirjautuminen</h2>
					<label for="inputStudentNumber" class="sr-only">Opiskelijanumero</label>
					<input name="onro" type="text" id="inputStudentNumber" class="form-control" placeholder="Opiskelijanumero" required>
					<label for="inputStudentPassword" class="sr-only">Salasana</label>
					<input name="salasana" type="password" id="inputStudentPassword" class="form-control" placeholder="Salasana" required>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu sisään</button>
					</br>
					<div class="text-center">
						<a class="btn btn-md btn-default" href="/student-registration">Rekisteröi uusi opiskelija</a>
					</div>
				</form>
				<form action="/teacher-login" method="POST" class="form-signin" id="teacherForm" style="display: none;">
					<h2>Opettajan kirjautuminen</h2>
					<label for="inputTeacherNumber" class="sr-only">Opettajanumero</label>
					<input name="onro" type="text" id="inputTeacherNumber" class="form-control" placeholder="Opettajanumero" required>
					<label for="inputTeacherPassword" class="sr-only">Salasana</label>
					<input name="salasana" type="password" id="inputTeacherPassword" class="form-control" placeholder="Salasana" required>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu sisään</button>
					</br>
					<div class="text-center">
						<a class="btn btn-md btn-default" href="/teacher-registration">Rekisteröi uusi opettaja</a>
					</div>
				</form>
				<form action="/admin-login" method="POST" class="form-signin" id="adminForm" style="display: none;">
					<h2>Ylläpidon kirjautuminen</h2>
					<label for="inputAdminUsername" class="sr-only">Käyttäjänimi</label>
					<input name="nimi" type="text" id="inputAdminUsername" class="form-control" placeholder="Käyttäjänimi" required>
					<label for="inputAdminPassword" class="sr-only">Salasana</label>
					<input name="salasana" type="password" id="inputAdminPassword" class="form-control" placeholder="Salasana" required>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu sisään</button>
					</br>
					<div class="text-center">
						<a class="btn btn-md btn-default" href="/admin-registration">Rekisteröi uusi ylläpitäjä</a>
					</div>
				</form>
				<div class="text-center">
					</br>
					<button type="button" class="btn btn-md" onclick="changeLoginType()">Vaihda kirjautumistyyppiä</button>
				</div>
			</div>
		</div>
	</div>
</div>