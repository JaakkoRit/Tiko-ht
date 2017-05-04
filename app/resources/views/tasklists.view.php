<?php require "_header.view.php"; ?>

    <h1>Kaikki tehtävälistat</h1>

    <hr>

    <ul>
        <?php foreach ($taskLists as $taskList) : ?>
            <li>
                <a href="/show-tasklist?id=<?= $taskList->ID_TLISTA; ?>">
                    <?= $taskList->KUVAUS; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <a href="/tasklists/create" class="button">Luo uusi tehtävälista</a>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>