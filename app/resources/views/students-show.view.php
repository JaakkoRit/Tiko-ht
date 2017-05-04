<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>

    <h1><?= $student->NIMI; ?></h1>
    <ul class="list-group">
        <li class="list-group-item"><?= $student->ONRO; ?></li>
        <li class="list-group-item"><?= $student->PAAAINE; ?></li>
    </ul>
    <h2>Suoritetut sessiot</h2>
    <?php foreach ($sessions as $session) : ?>
        <ul class="list-group">
            <li class="list-group-item">Sessio id: <?= $session->ID_SESSIO; ?></li>
            <li class="list-group-item">Tehtävälista id: <?= $session->ID_TLISTA; ?></li>
            <li class="list-group-item">Alkamisen ajankohta: <?= $session->ALKAIKA; ?></li>
            <li class="list-group-item">Loppumisen ajankohta: <?= $session->LOPAIKA; ?></li>
        </ul>
    <?php endforeach; ?>

<?php
    require 'message.view.php';
    require "_footer.view.php";