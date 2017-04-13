<?php require "_header.view.php"; ?>

    <form action="/teacher-registration" method="POST">

        <div class="field">
            <label class="label">Opettajanumero</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="onro" type="number">
            </p>
        </div>

        <div class="field">
            <label class="label">Nimi</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="nimi" type="text">
            </p>
        </div>

        <div class="field">
            <label class="label">Salasana</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="salasana" type="password">
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Rekisteröidy</button>
            </p>
        </div>

    </form>

<?php
require "message.view.php";
require "errors.view.php";
require "_footer.view.php";