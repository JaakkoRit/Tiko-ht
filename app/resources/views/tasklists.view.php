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
            <h2>Kaikki tehtävälistat</h2>
            <hr>
        </div>
        <div class="row">
            <ul class="list-group">
                <?php foreach ($taskLists as $taskList) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12 nopadding">
                    <li class="list-group-item">
                        <a href="/show-tasklist?id=<?= $taskList->ID_TLISTA; ?>">
                            <?= $taskList->KUVAUS; ?>
                        </a>
                    </li>
                </div>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="row">
            <hr>
            <a href="/tasklists/create" class="btn btn-med btn-primary">Luo uusi tehtävälista</a>
        </div>
    </div>

<?php require "_footer.view.php"; ?>