<?php
require "_header.view.php";
require "_navbar.view.php";
require "_sidebar.view.php";
?>

        <div class="container page-content">
            <?php foreach ($tasklistArray as $tasklist):?>
                <div class="row">
                    <div class="col-md-5 col-sm-12 styledtable">
                        <h3>Tehvalista <?php echo $tasklist->ID_TLISTA;?>:n sessioiden raportti</h3>
                        <table>
                            <tr>
                                <th>Nopein suoritus</th>
                                <th>Hitain suoritus</th>
                                <th>Keskimääräinen suoritus</th>
                            </tr>
                            <?php
                                $fastest = 0; $slowest = 0;$freq = 0; $avgtime = 0; $timesum = 0;
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
                                }
                            ?>
                            <tr>
                                <td><?= "$fastest sekuntia";?></td>
                                <td><?= "$slowest sekuntia";?></td>
                                <td><?= "$avgtime sekuntia";?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
            <?php endforeach;?>
        </div>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>