<?php require "_header.view.php"; ?>

    <section>
        <div>
            <?php foreach ($tasklistArray as $tasklist):?>
                <?php if($tasklist->ID_KAYTTAJA == $_SESSION['id_kayttaja']):?>
                    <h1>Tehvalista <?php echo $tasklist->ID_TLISTA;?>:n sessioiden raportti</h1>
                    <table>
                        <tr>
                            <th>Nopein suoritus</th>
                            <th>Hitain suoritus</th>
                            <th>Keskimääräinen suoritus</th>
                        </tr>
                        <?php $fastest = 0; $slowest = 0;$freq = 0; $avgtime = 0; $timesum = 0;
                        foreach ($sessionArray as $session){
                            if($session->ID_TLISTA == $tasklist->ID_TLISTA){
                                $time = $session->ALKAIKA;
                                sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
                                $strtime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

                                $time = $session->LOPAIKA;
                                sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
                                $endtime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

                                $timedif = $endtime - $strtime;
                                if($timedif < $fastest || $fastest == 0)
                                    $fastest = $timedif;
                                if($timedif > $slowest)
                                    $slowest = $timedif;
                                $freq++;
                                $timesum = $timesum + $timedif;
                                $avgtime = $timesum / $freq;
                            }
                        }?>
                        <tr>
                            <td><?php echo $fastest; echo " sekuntia";?></td>
                            <td><?php echo $slowest; echo " sekuntia";?></td>
                            <td><?php echo $avgtime; echo " sekuntia";?></td>
                        </tr>
                    </table>
                    <br>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </section>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>