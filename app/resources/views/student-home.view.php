<?php require "_header.view.php"; ?>

    <h1>Opiskelijan etusivu</h1>

    <hr>

    <ul>
        <?php foreach ($sessions as $session) : ?>
            <li><a href="/session?sessionid=<?= $session->ID_SESSIO; ?>&taskIndex=0" class="button">Sessio</a> </li>
        <?php endforeach; ?>
    </ul>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>