<?php require "_header.view.php"; ?>

<?php if(strlen($message) > 0): ?>
<div class="notification is-primary">
	<?= $message; ?>
</div>
<?php endif; ?>


<?php require "_footer.view.php"; ?>