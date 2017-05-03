<?php require "_header.view.php"; ?>

    <h1>Sessiot</h1>

    <hr>

    <ul>
        <?php foreach ($sessions as $session) : ?>
            <li>
                <a href="/show-tasklist?id=<?= $session->ID_TLISTA; ?>">
                    <?= "Kayttaja: $session->ID_KAYTTAJA Tehtävälista: $session->ID_TLISTA"; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <a href="/sessions-management/create" class="button">Luo uusi sessio</a>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>