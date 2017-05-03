<?php require "_header.view.php"; ?>

<?php require "_navbar.view.php"; ?>

<?php require "_sidebar.view.php"; ?>

                <?php if (auth()->ID_KAYTTAJA == $taskListCreator || \App\App\Models\Gate::hasRole('admin')):?>
                    <li><a href="/session-report" class="button">Sessioraportit</a> </li>
                    <li><a href="/tasklistsession-report" class="button">Tehtävälistan<br>suoritusaikaraportit</a> </li>
                    <li><a href="/teacher-home" class="button">Takaisin<br>etusivulle</a> </li>
                <?php endif;?>
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