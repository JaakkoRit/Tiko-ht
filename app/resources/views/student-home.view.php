<?php require "_header.view.php"; ?>

<?php require "_navbar.view.php"; ?>

<?php require "_sidebar.view.php"; ?>
                <?php foreach ($sessions as $session) : ?>
                    <li><a href="/session?sessionid=<?= $session->ID_SESSIO; ?>&taskIndex=0" class="button">Sessio</a> </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>