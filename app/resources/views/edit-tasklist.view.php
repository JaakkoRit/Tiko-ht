<?php require "_header.view.php"; ?>

    <h1>Muokkaa tehtävälistaa</h1>

    <hr>

    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li>
                <?= $task->KUVAUS; ?>
                <?php if ($task->ID_KAYTTAJA == auth()->ID_KAYTTAJA || \App\App\Models\Gate::hasRole('admin')) : ?>
                    <a href="/tasks/edit?id=<?= $task->ID_TEHTAVA; ?>" class="button is-warning">Muokkaa</a>
                <?php endif; ?>
                <form action="delete-taskfromtasklist?id=<?= $id; ?>" method="post">
                    <input type="hidden" name="tehtavaId" value="<?= $task->ID_TEHTAVA; ?>">
                    <input type="hidden" name="tlistaId" value="<?= $id; ?>">
                    <button type="submit" class="button is-danger">Poista</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <a href="/tasks/create?id=<?= $id; ?>" class="button">Lisää tehtävä</a>

<?php
    require 'message.view.php';
    require "_footer.view.php"; ?>