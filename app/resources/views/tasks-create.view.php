<?php require "_header.view.php"; ?>

    <h1>Luo uusi tehtävä</h1>
    <hr>
    <form action="/tasks/save" method="POST">
        <?php if (isset($id)) : ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
        <?php endif; ?>

        <label class="label">Tehtävän kuvaus</label>
        <input class="input" name="kuvaus" type="text">

        <label class="label">Vastaus</label>
        <input class="input" name="vastaus" type="text">

        <button type="submit" class="button is-primary">Tallenna</button>
    </form>
    <?php if (isset($id)) : ?>
        <hr>
        <h1>Valitse olemassa olevista tehtävista</h1>
        <hr>
        <form action="/tasklists/update" method="POST">
            <input type="hidden" name="id" value="<?= $id; ?>">

            <label class="label">Tehtävät</label>
            <input class="input" name="tehtavat" type="text"
                   placeholder="Kirjoita tehtävien numerot tyyliin: 1 4 15 20...">
            <button type="submit" class="button is-primary">Tallenna</button>
        </form>
        <hr>
        <h1>Tehtävät</h1>
        <hr>
        <ul>
            <?php foreach ($tasks as $task) : ?>
                <li><?= "$task->ID_TEHTAVA: $task->KUVAUS"; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<?php
require 'message.view.php';
require 'errors.view.php';
require "_footer.view.php";