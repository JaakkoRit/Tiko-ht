<?php require "_header.view.php"; ?>

    <h1>Luo uusi tehtävä</h1>

    <hr>

    <form action="/tasks/save" method="POST">

        <?php if (isset($id)) : ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
        <?php endif; ?>

        <div class="field">
            <label class="label">Tehtävän kuvaus</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="kuvaus" type="text">
            </p>
        </div>

        <div class="field">
            <label class="label">Vastaus</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="vastaus" type="text">
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Tallenna</button>
            </p>
        </div>

    </form>

    <hr>

    <?php if (isset($id)) : ?>
        <h1>Valitse olemassa olevista tehtävista</h1>
        <hr>
        <form action="/tasklists/update" method="POST">

            <input type="hidden" name="id" value="<?= $id; ?>">

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