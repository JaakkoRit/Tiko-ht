<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>
    <div class="container page-content">
        <?php
        require 'message.view.php';
        ?>
        <div class="row">
            <h1>Kaikki tehtävälistat</h1>

            <hr>
        </div>
        <div class="row">
            <ul class="list-group">
                <?php foreach ($taskLists as $taskList) : ?>
                    <li class="list-group-item">
                        <a href="/show-tasklist?id=<?= $taskList->ID_TLISTA; ?>">
                            <?= $taskList->KUVAUS; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <hr>
        </div>
        <div class="row">
            <a href="/tasklists/create" class="btn btn-med btn-primary">Luo uusi tehtävälista</a>
        </div>
    </div>

<?php require "_footer.view.php"; ?>