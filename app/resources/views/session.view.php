<?php require "_header.view.php"; ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target="#sidebar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">SQL-opetus</a>
                </div>
                <div class="col-md-1 pull-right">

                </div>
            </div>
        </div>
    </nav>
    <div class="content">
        <nav class="navbar navbar-inverse sidebar-left collapse navbar-collapse no-transition" id="sidebar">
            <?php if (isset($_SESSION['nimi'])) : ?>
                <p class="navbar-text"><?php echo $_SESSION['nimi']; ?></p>
            <?php endif; ?>
            <a class="navbar-link"href="/logout">Kirjaudu ulos</a>
            <hr>
            <ul class="nav navbar-nav">
            </ul>
        </nav>
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