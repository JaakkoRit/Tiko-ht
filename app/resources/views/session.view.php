<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_basicsidebar.view.php";
?>

        <div class="container page-content">
            <?php if (! isset($completed)) : ?>
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
                            <input type="hidden" value="/session?sessionid=<?= $sessionId; ?>" name="seuraavaSivu">
                            <br>
                            <button type="submit" class="btn btn-lg is-primary btn-primary">Lähetä</button>
                        </div>
                    </form>
                </div>
            <?php else : ?>
                <div class="row">
                    <a href="<?= getHomePage(); ?>" class="btn btn-lg is-primary btn-primary">Etusivulle</a>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-5 col-sm-12 styledtable">
                    <br>
                    <strong>Tässä edellisen kyselysi tulos:</strong>
                    <?= $queryResult; ?>
                    <?php if (isset($errors) && count($errors) > 0) : ?>
                        <div class="alert alert-danger">
                            <?= $errors; ?>
                        </div>
                    <?php endif; ?>
                    <strong>Oikea tulos:</strong>
                    <?= $correctTable; ?>
                </div>
            </div>
			<div class="row">
				<hr>
				<h3>Esimerkkitietokannan taulut</h3>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12 styledtable">
					<?= $courses;?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12 styledtable">
					<?= $students;?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12 styledtable">
					<?= $courseCompletion;?>
				</div>
			</div>
        </div>


<?php
    require 'message.view.php';
    require "_footer.view.php";