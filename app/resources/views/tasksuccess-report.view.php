<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>

    <div class="container page-content">
        <?php require 'message.view.php';?>
        <div class="row">
            <h2>Tehtävissä onnistuminen pääaineittain</h2>
        </div>
        <div class="row">
            <div class="col-med-6 col-sm-12 nopadding"
                <p><b>Perustelu:</b><br>Tehtävissä onnistumista mitataan keskimäärin käytettyjen yritysten määrän ja ajan perusteella.</p>
            </div>
        </div>
        <div class="row">
            <?= $report;?>
        </div>
    </div>
<?php
    require "_footer.view.php";