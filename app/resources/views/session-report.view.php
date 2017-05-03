<?php require "_header.view.php"; ?>

<?php require "_navbar.view.php"; ?>

<?php require "_sidebar.view.php"; ?>

        <div class="container">
            <?php foreach ($tasklistArray as $tasklist):?>
                <h3>Sessiot tehtävälistasta <?php Echo $tasklist->ID_TLISTA;?></h3>
                <div class="row">
                    <div class="col-sm-5">
                        <table>
                            <tr>
                                <th>Sessio</th>
                                <th>Opiskelija</th>
                                <th>Onnistuneiden lkm</th>
                                <th>Suoritettu</th>
                            </tr>
                            <?php foreach($sessionArray as $session):?>
                                <tr>
                                    <?php if($session->ID_TLISTA == $tasklist->ID_TLISTA):?>
                                        <td><?php Echo $session->ID_SESSIO;?></td>
                                        <td><?php foreach ($studentArray as $student){
                                            if($student->ID_KAYTTAJA == $session->ID_KAYTTAJA)
                                                Echo $student->NIMI;
                                            }
                                            ?></td>
                                        <td><?php $rightcount = 0;foreach ($attemptArray as $attempt){

                                                if($attempt->OLIKOOIKEIN == '1' && $attempt->ID_SESSIO == $session->ID_SESSIO)
                                                    $rightcount++;
                                            }
                                            Echo $rightcount; ?></td>
                                        <td><?php if($session->LOPAIKA == null)
                                            echo "Ei";
                                        else echo "Kyllä";?></td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <br>
            <?php endforeach;?>
        </div>
    </div>
<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>