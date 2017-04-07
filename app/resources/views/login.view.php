<?php require "_header.view.php"; ?>

    <form action="/login" method="POST">
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

<?php require "_footer.view.php"; ?>