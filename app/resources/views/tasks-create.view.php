<?php
    require "_header.view.php";
    require "_navbar.view.php";
    require "_sidebar.view.php";
?>
<div class="container page-content">
    <?php
    require 'message.view.php';
    require 'errors.view.php';
    ?>
    <div class="row">
        <h2>Luo uusi tehtävä</h2>
        <hr>
    </div>
    <form action="/tasks/save" method="POST">
        <div class="row">
            <?php if (isset($id)) : ?>
                <input type="hidden" name="id" value="<?= $id; ?>">
            <?php endif; ?>
            <div class="col-md-5 col-sm-12 nopadding">
                <p>Tehtävän kuvaus</p>
                <input class="input full-width" name="kuvaus" type="text">
            </div>
            <div class="col-md-1 col-sm-12 nopadding">
            </div>
            <div class="col-md-5 col-sm-12 nopadding">
                <p>Vastaus</p>
                <input class="input full-width" name="vastaus" type="text">
            </div>
        </div>
        <div class="row">
            <br>
            <button type="submit" class="btn btn-med btn-primary">Tallenna</button>
        </div>
    </form>
    <?php if (isset($id)) : ?>
    <div class="row">
        <hr>
        <h3>Valitse olemassa olevista tehtävista</h3>
        <hr>
    </div>
    <form action="/tasklists/update" method="POST">
        <div class="row">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="col-md-5 col-sm-12 nopadding">
                <p>Tehtävät</p>
                <input class="input full-width" name="tehtavat" type="text"
                       placeholder="Kirjoita tehtävien numerot tyyliin: 1 4 15 20...">
            </div>
        </div>
        <div class="row">
            <br>
            <button type="submit" class="btn btn-med btn-primary">Tallenna</button>
        </div>
    </form>
    <div class="row">
        <hr>
        <h3>Tehtävät</h3>
        <hr>
    </div>
    <div class="row">
        <ul class="list-group">
            <?php foreach ($tasks as $task) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12 nopadding">
                <li class="list-group-item"><?= "$task->ID_TEHTAVA: $task->KUVAUS"; ?></li>
            </div>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>

<?php
require 'message.view.php';
require 'errors.view.php';
require "_footer.view.php";