<?php require "_header.view.php"; ?>

    <h1><?= $task->KUVAUS; ?></h1>
    <hr>
    <form action="/session" method="POST">

        <div class="field">
            <label class="label">Vastaus</label>
            <p class="control">
                <textarea name="vastaus" class="textarea" placeholder="Vastaus"></textarea>
            </p>
        </div>

        <input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="tehtavaId">
        <input type="hidden" value="<?= $_GET['sessionid']; ?>" name="sessionId">
        <input type="hidden" value="<?= $timeAtStart; ?>" name="timeAtStart">
        <input type="hidden" value="/session?sessionid=<?= $sessionId; ?>&taskIndex=<?= $taskIndex+1; ?>" name="seuraavaSivu">

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Lähetä</button>
            </p>
        </div>

    </form>
    <hr>
    <?php echo $courses;?>
    <?php echo $students;?>
    <?php echo $courseCompletion;?>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>