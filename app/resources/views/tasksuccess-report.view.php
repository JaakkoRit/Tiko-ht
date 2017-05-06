<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>

    <div class="container page-content">
        <?php require 'message.view.php';?>
        <div class="row">
            <?= $report;?>
        </div>
    </div>
<?php
    require "_footer.view.php";