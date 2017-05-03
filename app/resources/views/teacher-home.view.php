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
                <li><a href="/session-report" class="button">Sessioraportit</a> </li>
                <li><a href="/tasklistsession-report" class="button">Tehtävälistan <br> suoritusaikaraportit</a> </li>
            </ul>
        </nav>
    </div>
<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>