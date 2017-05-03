<?php require "_header.view.php"; ?>

    <h1>Kaikki tehtävät</h1>

    <hr>

    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li>
                <?= $task->KUVAUS; ?>
                <?php if ($task->ID_KAYTTAJA == auth()->ID_KAYTTAJA || \App\App\Models\Gate::hasRole('admin')) : ?>
                    <a href="/tasks/edit?id=<?= $task->ID_TEHTAVA; ?>" class="button is-warning">Muokkaa</a>
                    <form action="/tasks/delete" method="post">
                        <input type="hidden" name="id" value="<?= $task->ID_TEHTAVA; ?>">
                        <button type="submit" class="button is-danger">Poista</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <a href="/tasks/create" class="button">Lisää tehtävä</a>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>