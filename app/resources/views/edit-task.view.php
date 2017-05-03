<?php require "_header.view.php"; ?>

    <h1>Muokkaa tehtävää</h1>

    <hr>

    <form action="/tasks/update" method="post">

        <input type="hidden" value="<?= $task->ID_TEHTAVA; ?>" name="id">

        <div class="field">
            <label class="label">Tehtävän kuvaus</label>
            <p class="control">
                <input class="input" name="kuvaus" type="text" value="<?= $task->KUVAUS; ?>">
            </p>
        </div>

        <div class="field">
            <label class="label">Vastaukset</label>
        </div>

        <?php $index = 0;
        foreach ($answers as $answer) : ?>
            <div class="field">
                <p class="control">
                    <input type="hidden" name="alkuperainen<?= $index; ?>" value="<?= $answer->VASTAUS; ?>">
                    <input class="input" name="vastaus<?= $index; ?>" type="text" value="<?= $answer->VASTAUS; ?>">
                </p>
                <p class="control">
                    <a href="/answers/delete?index=<?= $index; ?>&id=<?= $task->ID_TEHTAVA; ?>" class="button is-danger is-right">Poista</a>
                </p>
                <?php $index += 1; ?>
            </div>
        <?php endforeach; ?>

        <div class="field is-grouped">
            <p class="control">
                <a href="/answers/create?id=<?= $task->ID_TEHTAVA; ?>" class="button is-primary">Lisää vastaus</a>
            </p>
        </div>

        <hr>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Tallenna</button>
            </p>
            <p class="control">
                <a href="<?= getReferer(); ?>" class="button">Takaisin</a>
            </p>
        </div>

    </form>

<?php
require 'message.view.php';
require 'errors.view.php';
require "_footer.view.php";