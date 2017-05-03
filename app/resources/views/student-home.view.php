<?php require "_header.view.php"; ?>
<?php require "_navbar.view.php"; ?>
<?php require "_sidebar.view.php"; ?>

    <div class="row">
        <div class="column">
            <ul class="list-group">
                <?php if (\App\App\Models\Gate::hasRole('opiskelija')): ?>
                    <?php foreach ($sessions as $session) : ?>
                        <li><a href="/session?sessionid=<?= $session->ID_SESSIO; ?>&taskIndex=0"
                               class="list-group-item">Sessio</a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

<?php require 'message.view.php'; ?>
<?php require "_footer.view.php"; ?>