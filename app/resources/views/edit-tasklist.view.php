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
		<h1>Muokkaa tehtävälistaa</h1>
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
                        <form action="delete-taskfromtasklist?id=<?= $id; ?>" method="post">
                            <?php if ($task->ID_KAYTTAJA == auth()->ID_KAYTTAJA || \App\App\Models\Gate::hasRole('admin')) : ?>
                                <a href="/tasks/edit?id=<?= $task->ID_TEHTAVA; ?>" class="btn btn-sm btn-primary">Muokkaa</a>
                            <?php endif; ?>
                            <input type="hidden" name="tehtavaId" value="<?= $task->ID_TEHTAVA; ?>">
                            <input type="hidden" name="tlistaId" value="<?= $id; ?>">
                            <button type="submit" class="btn btn-sm btn-danger pull-right">Poista</button>
                        </form>
                    </div>
                </div>
                <br>
                <?php endforeach; ?>
            </ul>
		</div>
	</div>
	<div class="row">
		<hr>
		<a href="/tasks/create?id=<?= $id; ?>" class="btn btn-md btn-primary">Lisää tehtävä</a>
	</div>
</div>
<?php
    require "_footer.view.php"; ?>