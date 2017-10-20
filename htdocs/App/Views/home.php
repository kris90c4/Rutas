<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<?php if (isset($saludo)) {?>
	<h1 id="saludo"><?= $saludo ?></h1>
<?php } ?>

<?php if (isset($error)) {?>
	<h1 id="saludo"><?= $error ?></h1>
<?php } ?>
<!--div id="portada">
<h2>La web se ha migrado a la siguiente dirección</h2>
<a href="http://app.gestoriaportol.com">app.gestoriaportol.com</a>
</div-->
