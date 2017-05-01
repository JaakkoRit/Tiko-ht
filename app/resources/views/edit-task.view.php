<?php require "_header.view.php"; ?>

    <h1>Muokkaa tehtävää</h1>

    <hr>

    <form action="/tasks/update" method="post">

        <div class="field">
            <label class="label">Tehtävän kuvaus</label>
            <p class="control">
                <input class="input" name="kuvaus" type="text" value="<?= $task->KUVAUS; ?>">
            </p>
        </div>

        <div class="field">
            <label class="label">Vastaukset</label>
        </div>

        <?php $index = 0; foreach ($answers as $answer) : ?>
            <div class="field is-grouped">
                <p class="control">
                    <input class="input" name="vastaus<?= $index; ?>" type="text" value="<?= $answer->VASTAUS; ?>">
                </p>
                <p class="control">
                    <a href="" class="button is-danger is-right">Poista</a>
                </p>
            </div>
            <?php $index += 1; ?>
        <?php endforeach; ?>

        <div class="field is-grouped">
            <p class="control">
                <button type="submit" class="button is-primary">Tallenna</button>
            </p>
        </div>

    </form>

    <hr>

    <a href="/tasks/create" class="button">Lisää tehtävä</a>

<?php
    require 'message.view.php';
    require 'errors.view.php';
    require "_footer.view.php";