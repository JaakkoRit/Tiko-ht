<?php require "_header.view.php"; ?>

<?php require "_navbar.view.php"; ?>

<?php require "_sidebar.view.php"; ?>

        <div class="container">
            <h1><?= $task->KUVAUS; ?></h1>
            <hr>
            <form action="/session" method="POST">

                <div class="field row">
                    <label class="label">Vastaus</label>
                    <p class="control">
                        <textarea name="vastaus" class="textarea col-sm-12" placeholder="Vastaus"></textarea>
                    </p>
                </div>

                <input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="tehtavaId">
                <input type="hidden" value="<?= $_GET['sessionid']; ?>" name="sessionId">
                <input type="hidden" value="<?= $timeAtStart; ?>" name="timeAtStart">
                <input type="hidden" value="/session?sessionid=<?= $sessionId; ?>&taskIndex=<?= $taskIndex+1; ?>" name="seuraavaSivu">

                <div class="field is-grouped row">
                    <p class="control col-sm-1">
                        <button type="submit" class="btn btn-lg is-primary btn-primary">Lähetä</button>
                    </p>
                </div>

            </form>
            <hr>
            <h3>Esimerkkitietokannan taulut</h3>
            <div class="row">
                <div class="col-sm-5">
                    <?php echo $courses;?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <?php echo $students;?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <?php echo $courseCompletion;?>
                </div>
            </div>


        </div>
    </div>


<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>