<?php require "_header.view.php"; ?>

    <section>
        <div>
            <?php foreach ($tasklistArray as $tasklist):?>
                <?php if($tasklist->ID_KAYTTAJA == $_SESSION['id_kayttaja']):?>
                    <h1>Sessiot tehtävälistasta <?php Echo $tasklist->ID_TLISTA;?></h1>
                    <table>
                        <tr>
                            <th>Sessio</th>
                            <th>Opiskelija</th>
                            <th>Onnistuneiden lkm</th>
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
                                <?php endif;?>
                            </tr>
                        <?php endforeach;?>
                    </table>
                    <br>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </section>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>