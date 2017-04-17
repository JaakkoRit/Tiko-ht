<?php require "_header.view.php"; ?>

    <form action="/admin-login" method="POST">
        <div class="field">
            <label class="label">Ylläpitäjän nimi</label>
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
                <button type="submit" class="button is-primary">Kirjaudu</button>
            </p>
        </div>
    </form>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>