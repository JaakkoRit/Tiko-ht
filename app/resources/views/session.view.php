<?php
require "_header.view.php";
require "_navbar.view.php";
require "_basicsidebar.view.php";
?>
    <div class="container page-content">
        <?php
        require 'message.view.php';
        ?>
        <?php if (!isset($completed)) : ?>
            <div class="row">
                <h1><?= $task->KUVAUS; ?></h1>
            </div>
            <div class="row">
                <form action="/session" method="POST">
                    <div class="col-md-5 col-sm-12 styledtable">
                        <textarea name="vastaus" class="textarea full-width" placeholder="Vastaus"></textarea>
                        <input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="tehtavaId">
                        <input type="hidden" value="<?= $_GET['sessionid']; ?>" name="sessionId">
                        <input type="hidden" value="<?= $task->KYSELYTYYPPI; ?>" name="tyyppi">
                        <input type="hidden" value="<?= $timeAtStart; ?>" name="timeAtStart">
                        <input type="hidden" value="/session?sessionid=<?= $sessionId; ?>" name="seuraavaSivu">
                        <br>
                        <button type="submit" class="btn btn-lg is-primary btn-primary">Lähetä</button>
                    </div>
                </form>
            </div>
        <?php else : ?>
            <div class="row">
                <a href="<?= getHomePage(); ?>" class="btn btn-lg is-primary btn-primary" style="margin-top: 10px;">Etusivulle</a>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-5 col-sm-12 styledtable">
                <br>
                <?php if (isset($correct)) : ?>
                    <?php if ($correct == true) : ?>
                        <div class="alert alert-success">
                            Vastaus oikein
                        </div>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            Vastaus väärin
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($errors) && count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                            <p><b><?= $error; ?></b></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($syntaxErrors) && $syntaxErrors != null) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($syntaxErrors as $error) : ?>
                            <p><b><?= $error; ?></b></p>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <strong>Tässä edellisen kyselysi tulos:</strong>
                    <?php if (isset($sqlError) && $sqlError != null) : ?>
                        <div class="alert alert-danger">
                            <p><?= $sqlError; ?></p>
                        </div>
                    <?php else: ?>
                        <?= $queryResult; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <strong>Oikea tulos:</strong>
                <?= $correctTable; ?>
                <?php if (isset($correctAnswer) && $correctAnswer != null) : ?>
                    <div class="alert alert-warning">
                        <strong>Oikea vastaus olisi ollut esimerkiksi:</strong>
                        <br>
                        <?= $correctAnswer; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <hr>
            <h3>Esimerkkitietokannan taulut</h3>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-12 styledtable">
                <?= $courses; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-12 styledtable">
                <?= $students; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-12 styledtable">
                <?= $courseCompletion; ?>
            </div>
        </div>
    </div>
<?php
require "_footer.view.php";