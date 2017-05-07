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
        <h2>Luo uusi sessio</h2>
        <hr>
    </div>
    <form action="/sessions-management/save" method="POST">
        <div class="row">
            <div class="col-md-5 col-sm-12 nopadding">
                <p>Käyttäjien id:t</p>
                <input class="input full-width" name="kayttajat" type="text">
            </div>
            <div class="col-md-1 col-sm-12 nopadding">
            </div>
            <div class="col-md-5 col-sm-12 nopadding">
                <p>Tehtävälista</p>
                <input class="input full-width" name="tehtavalista" type="text">
            </div>
        </div>
        <div class="row">
            <br>
            <button type="submit" class="btn btn-med btn-primary">Tallenna</button>
            <hr>
        </div>
    </form>
    <div class="row">
        <ul class="list-group">
            <?php foreach ($students as $student) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12 nopadding">
                <li class="list-group-item"><?= "Opiskelijan id: $student->ID_KAYTTAJA, Nimi: $student->NIMI"; ?></li>
            </div>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="row">
        <hr>
    </div>
    <div class="row">
        <ul class="list-group">
            <?php foreach ($taskLists as $taskList) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12 nopadding">
                <li class="list-group-item"><?= "Tehtävälistan id: $taskList->ID_TLISTA, Kuvaus: $taskList->KUVAUS"; ?></li>
            </div>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php
    require "_footer.view.php";
