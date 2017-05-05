<nav class="navbar navbar-inverse sidebar-left collapse navbar-collapse no-transition" id="sidebar">
    <?php if (isset($_SESSION['nimi'])) : ?>
        <p class="navbar-text"><?php echo $_SESSION['nimi']; ?></p>
    <?php endif; ?>
    <a class="navbar-link"href="/logout">Kirjaudu ulos</a>
    <hr>
    <ul class="nav navbar-nav">
        <?php if (\App\App\Models\Gate::hasRole('opettaja') || \App\App\Models\Gate::hasRole('admin')):?>
            <li><a href="/session-report">Sessioraportit</a></li>
            <li><a href="/tasklistsession-report">Sessioiden<br>suoritusaikaraportit</a></li>
            <li><a href="/tasklisttask-report">Tehtävien<br>suoritusraportit</a></li>
            <li><a href="/taskdifficulty-report">Tehtävien<br>vaikeusraportit</a></li>
            <li><a href="/students">Oppilaat</a></li>
            <?php if (! urlMatches('/-home$/')) : ?>
                <li><a href="/teacher-home" class="button">Takaisin<br>etusivulle</a> </li>
            <?php endif; ?>
        <?php endif;?>
        <?php if (\App\App\Models\Gate::hasRole('opiskelija')): ?>
            <?php foreach ($sessions as $session) : ?>
                <li>
                    <a href="/session?sessionid=<?= $session->ID_SESSIO; ?>&taskIndex=0">Sessio</a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</nav>