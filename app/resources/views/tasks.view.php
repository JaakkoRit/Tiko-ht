<?php
require "_header.view.php";
require "_navbar.view.php";
require "_sidebar.view.php";
?>
    <div class="container page-content">
        <?php
        require 'message.view.php';
        ?>
        <div class="row">
            <h1>Kaikki tehtävät</h1>

            <hr>
        </div>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <?php foreach ($tasks as $task) : ?>
                    <div class="row">
                        <div class="col-sm-12 nopadding">
                            <li class="list-group-item">
                                <?= $task->KUVAUS; ?>
                            </li>
                            <?php if ($task->ID_KAYTTAJA == auth()->ID_KAYTTAJA || \App\App\Models\Gate::hasRole('admin')) : ?>
                                <form action="/tasks/delete" method="post">
                                    <a href="/tasks/edit?id=<?= $task->ID_TEHTAVA; ?>" class="btn btn-sm btn-primary">Muokkaa</a>
                                    <input type="hidden" name="id" value="<?= $task->ID_TEHTAVA; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger pull-right">Poista</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <br>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <hr>
            <a href="/tasks/create" class="btn btn-med btn-primary">Lisää tehtävä</a>
        </div>
    </div>
<?php require "_footer.view.php";
