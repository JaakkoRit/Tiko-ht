<?php require "_header.view.php"; ?>

    <form action="/register" method="POST">
        <div class="field">
            <label class="label">Name</label>
            <p class="control">
                <input class="input" name="name" type="text" placeholder="Text input">
            </p>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="email" type="text" placeholder="Email input">
            </p>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <p class="control has-icon has-icon-right">
                <input class="input" name="password" type="password" placeholder="Password input">
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Submit</button>
            </p>
        </div>
    </form>

    <?php if (isset($message)) {
        echo '<hr>';
        view('message', compact('message'));
    } ?>

    <?php if (isset($errors)) {
        echo '<hr>';
        view('errors', compact('errors'));
    } ?>

<?php require "_footer.view.php"; ?>