<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/<?=$asset?>css/style.css">
		<link rel="stylesheet" type="text/css" href="/<?=$asset?>css/jquery.dataTables.min.css">
		<script type="text/javascript" src="/<?=$asset?>js/index.js"></script>
		<script type="text/javascript" src="/<?=$asset?>js/Ajax.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/jquery-1.12.4.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/jquery.dataTables.min.js"></script>
		
	</head>
	<body>
	<?= $menu; ?>


		<div id="cuerpo">
		<?= $content; ?>
		
		</div>
	</body>
</html>