<div class="content">
    <nav class="navbar navbar-inverse sidebar-left collapse navbar-collapse no-transition" id="sidebar">
        <?php if (isset($_SESSION['nimi'])) : ?>
            <p class="navbar-text"><?php echo $_SESSION['nimi']; ?></p>
        <?php endif; ?>
        <a class="navbar-link"href="/logout">Kirjaudu ulos</a>
        <hr>
        <ul class="nav navbar-nav">
            <?php if (\App\App\Models\Gate::hasRole('opiskelija')):?>
                <?php foreach ($sessions as $session) : ?>
                    <li><a href="/session?sessionid=<?= $session->ID_SESSIO; ?>&taskIndex=0" class="button">Sessio</a> </li>
                <?php endforeach; ?>
            <?php endif;?>
            <?php if (\App\App\Models\Gate::hasRole('opettaja') || \App\App\Models\Gate::hasRole('admin')):?>
                <li><a href="/session-report" class="button">Sessioraportit</a> </li>
                <li><a href="/tasklistsession-report" class="button">Tehtävälistan<br>suoritusaikaraportit</a> </li>
                <li><a href="/teacher-home" class="button">Takaisin<br>etusivulle</a> </li>
            <?php endif;?>
        </ul>
    </nav>


