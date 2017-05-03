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
        <div class="container">
            <?php foreach ($tasklistArray as $tasklist):?>
                <h3>Tehvalista <?php echo $tasklist->ID_TLISTA;?>:n sessioiden raportti</h3>
                <div class="row">
                    <div class="col-sm-5">
                        <table>
                            <tr>
                                <th>Nopein suoritus</th>
                                <th>Hitain suoritus</th>
                                <th>Keskimääräinen suoritus</th>
                            </tr>
                            <?php $fastest = 0; $slowest = 0;$freq = 0; $avgtime = 0; $timesum = 0;
                            foreach ($sessionArray as $session){
                                if($session->LOPAIKA != null) {
                                    if ($session->ID_TLISTA == $tasklist->ID_TLISTA) {
                                        $time = $session->ALKAIKA;
                                        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
                                        $strtime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

                                        $time = $session->LOPAIKA;
                                        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
                                        $endtime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

                                        $timedif = $endtime - $strtime;
                                        if ($timedif < $fastest || $fastest == 0)
                                            $fastest = $timedif;
                                        if ($timedif > $slowest)
                                            $slowest = $timedif;
                                        $freq++;
                                        $timesum = $timesum + $timedif;
                                        $avgtime = $timesum / $freq;
                                    }
                                }
                            }?>
                            <tr>
                                <td><?php echo "$fastest sekuntia";?></td>
                                <td><?php echo "$slowest sekuntia";?></td>
                                <td><?php echo "$avgtime sekuntia";?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
            <?php endforeach;?>
        </div>
    </div>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>