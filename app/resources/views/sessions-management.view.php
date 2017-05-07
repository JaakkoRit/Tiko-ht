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
			<h2>Sessiot</h2>
	</div>
	<div class="row">
	<hr>
            <ul class="list-group">
                <?php foreach ($sessions as $session) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 nopadding">
                    <li class="list-group-item">
                        <a href="/show-tasklist?id=<?= $session->ID_TLISTA; ?>">
                            <?= "Kayttaja: $session->ID_KAYTTAJA";?> <?="Tehtävälista: $session->ID_TLISTA";?>
                        </a>
                    </li>
                    </div>
                <?php endforeach; ?>
	        </ul>
	</div>
    <div class="row">
        <hr>
        <a href="/sessions-management/create" class="btn btn-md btn-primary">Luo uusi sessio</a>
    </div>
</div>
<?php
    require "_footer.view.php";