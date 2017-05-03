<?php require "_header.view.php"; ?>

    <h1>Uusi vastaus</h1>
    <hr>
    <form action="/answers/save" method="post">

        <input type="hidden" name="id" value="<?= $id; ?>">

        <label class="label">Vastaus</label>
        <input class="input" name="vastaus" type="text">

        <button type="submit" class="button is-primary">Tallenna</button>

    </form>

<?php
require 'message.view.php';
require 'errors.view.php';
require "_footer.view.php";