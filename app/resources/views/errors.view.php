<?php if (isset($errors) && count($errors) > 0) : ?>
	<div class="row alert alert-warning nomargin text-center">
		<div class="col-sm-12">
            <?php foreach ($errors as $error) : ?>
					<p><b><?php echo $error; ?></b></p>
            <?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

