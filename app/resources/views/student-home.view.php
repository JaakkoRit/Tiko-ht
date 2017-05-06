<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>

<div class="container page-content">
    <?php require 'message.view.php'; ?>
    <div class="row">
        <h3>Suorittamasi sessiot</h3>
    </div>
    <div class="row">
        <?= $completedSessionsReport;?>
    </div>
</div>

<?php require "_footer.view.php";
