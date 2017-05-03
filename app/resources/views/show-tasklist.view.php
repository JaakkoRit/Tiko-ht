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
        <a href="/edit-tasklist?id=<?= $id; ?>" class="button">Muokkaa listaa</a>
    <?php endif; ?>

<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>