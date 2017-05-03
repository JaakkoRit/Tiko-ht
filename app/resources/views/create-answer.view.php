<?php require "_header.view.php"; ?>

    <h1>Uusi vastaus</h1>

    <hr>

    <form action="/answers/save" method="post">

        <input type="hidden" name="id" value="<?= $id; ?>">

        <div class="field">
            <label class="label">Vastaus</label>
            <p class="control">
                <input class="input" name="vastaus" type="text">
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Tallenna</button>
            </p>
        </div>

    </form>

<?php
    require 'message.view.php';
    require 'errors.view.php';
    require "_footer.view.php";