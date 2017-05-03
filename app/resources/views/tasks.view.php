<?php require "_header.view.php"; ?>

    <h1>Kaikki tehtävät</h1>

    <hr>

    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li><?= $task->KUVAUS; ?></li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <a href="/tasks/create" class="button">Lisää tehtävä</a>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>