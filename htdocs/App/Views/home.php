<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<?php if (isset($saludo)) {?>
	<h1 id="saludo"><?= $saludo ?></h1>
<?php } ?>

<?php if (isset($error)) {?>
	<h1 id="saludo"><?= $error ?></h1>
<?php } ?>