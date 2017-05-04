<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_basicsidebar.view.php";
?>

        <div class="container page-content">
			<div class="row">
				<h1><?= $task->KUVAUS; ?></h1>
			</div>
			<div class="row">
				<form action="/session" method="POST">
					<div class="col-md-5 col-sm-12 styledtable">
						<textarea name="vastaus" class="textarea answer" placeholder="Vastaus"></textarea>
						<input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="tehtavaId">
						<input type="hidden" value="<?= $_GET['sessionid']; ?>" name="sessionId">
						<input type="hidden" value="<?= $timeAtStart; ?>" name="timeAtStart">
						<input type="hidden" value="/session?sessionid=<?= $sessionId; ?>&taskIndex=<?= $taskIndex+1; ?>" name="seuraavaSivu">
						<br>
						<button type="submit" class="btn btn-lg is-primary btn-primary">Lähetä</button>
					</div>
				</form>
			</div>
            <div class="row">
                <div class="col-md-5 col-sm-12 styledtable">
                    <br>
                    <?php echo "Tässä edellisen kyselysi tulos". $queryResult;?>
                </div>
            </div>
			<div class="row">
				<hr>
				<h3>Esimerkkitietokannan taulut</h3>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12 styledtable">
					<?php echo $courses;?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12 styledtable">
					<?php echo $students;?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12 styledtable">
					<?php echo $courseCompletion;?>
				</div>
			</div>
        </div>


<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>