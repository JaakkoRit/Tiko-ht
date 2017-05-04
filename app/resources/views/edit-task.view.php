<?php require "_header.view.php"; ?>

    <h1>Muokkaa tehtävää</h1>

    <hr>

    <form action="/tasks/update" method="post">

        <input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="id">

        <label class="label">Tehtävän kuvaus</label>
        <input class="input" name="kuvaus" type="text" value="<?= $task->KUVAUS; ?>">

        <label class="label">Vastaukset</label>

        <?php $index = 0; foreach ($answers as $answer) : ?>
            <input type="hidden" name="alkuperainen<?= $index; ?>" value="<?= $answer->VASTAUS; ?>">
            <input class="input" name="vastaus<?= $index; ?>" type="text" value="<?= $answer->VASTAUS; ?>">
            <a href="/answers/delete?index=<?= $index; ?>&id=<?= $task->ID_TEHTAVA; ?>"
               class="button is-danger is-right">Poista</a>
            <?php $index += 1; ?>
        <?php endforeach; ?>

        <a href="/answers/create?id=<?= $task->ID_TEHTAVA; ?>" class="button is-primary">Lisää vastaus</a>

        <hr>

        <button type="submit" class="button is-primary">Tallenna</button>
        <a href="<?= getReferer(); ?>" class="button">Takaisin</a>

    </form>

<?php
    require 'message.view.php';
    require 'errors.view.php';
    require "_footer.view.php";