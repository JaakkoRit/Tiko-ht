<?php require "_header.view.php"; ?>

    <h1>Luo uusi tehtävä</h1>

    <hr>

    <form action="/tasks/save" method="POST">

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

<?php
    require 'message.view.php';
    require 'errors.view.php';
    require "_footer.view.php";