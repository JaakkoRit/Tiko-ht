<?php require "_header.view.php"; ?>

    <h1>Tehtävälistan tehtävät</h1>

    <hr>

    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li><?= $task->KUVAUS; ?></li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <?php if (auth()->ID_KAYTTAJA == $taskListCreator || \App\App\Models\Gate::hasRole('admin')) : ?>
        <div class="field is-grouped">
            <p class="control">
                <a href="/edit-tasklist?id=<?= $id; ?>" class="button">Muokkaa listaa</a>
            </p>
            <p class="control">
                <form action="/tasklists/delete" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit" class="button is-danger">Poista lista</button>
                </form>
            </p>
        </div>
    <?php endif; ?>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>