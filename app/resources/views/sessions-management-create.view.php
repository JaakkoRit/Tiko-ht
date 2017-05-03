<?php require "_header.view.php"; ?>

    <h1>Luo uusi sessio</h1>

    <hr>

    <form action="/sessions-management/save" method="POST">

        <div class="field">
            <label class="label">Käyttäjien id:t</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="kayttajat" type="text">
            </p>
        </div>

        <div class="field">
            <label class="label">Tehtävälista</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="tehtavalista" type="text">
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Tallenna</button>
            </p>
        </div>

    </form>

    <hr>

    <?php foreach ($students as $student) : ?>
        <li><?= "Opiskelijan id: $student->ID_KAYTTAJA, Nimi: $student->NIMI"; ?></li>
    <?php endforeach; ?>

    <hr>

    <?php foreach ($taskLists as $taskList) : ?>
        <li><?= "Tehtävälistan id: $taskList->ID_TLISTA, Kuvaus: $taskList->KUVAUS"; ?></li>
    <?php endforeach; ?>

<?php
    require 'message.view.php';
    require 'errors.view.php';
    require "_footer.view.php";
