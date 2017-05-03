<?php require "_header.view.php"; ?>

    <h1>Luo uusi tehtävälista</h1>

    <hr>

    <form action="/tasklists/save" method="POST">

        <div class="field">
            <label class="label">Tehtävälistan kuvaus</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="kuvaus" type="text">
            </p>
        </div>

        <div class="field">
            <label class="label">Tehtävät</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="tehtavat" type="text" placeholder="Kirjoita tehtävien numerot tyyliin: 1 4 15 20...">
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Tallenna</button>
            </p>
        </div>

    </form>

    <hr>

    <h2>Tehtävät</h2>

    <hr>

    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li><?= "$task->ID_TEHTAVA: $task->KUVAUS"; ?></li>
        <?php endforeach; ?>
    </ul>

<?php
    require 'message.view.php';
    require 'errors.view.php';
    require "_footer.view.php";