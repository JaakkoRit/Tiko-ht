<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>

    <h1>Kaikki oppilaat</h1>
    <ul class="list-group">
        <?php foreach ($students as $student) : ?>
            <li class="list-group-item">
                <?= $student->NIMI; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <h1>Oppilaat, jotka ovat suorittaneet sessiosi</h1>
    <ul class="list-group">
        <?php foreach ($sessionStudents as $student) : ?>
            <li class="list-group-item">
                <form action="/students/show" method="post">
                    <input type="hidden" name="id" value="<?= $student->ID_KAYTTAJA; ?>">
                    <button type="submit"><?= $student->NIMI; ?></button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

<?php require 'message.view.php'; ?>
<?php require "_footer.view.php"; ?>