<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/<?=$asset?>css/style.css">
		<script type="text/javascript" src="/<?=$asset?>js/index.js"></script>
	</head>
	<body>
	
	<?= $menu; ?>


		<div id="cuerpo">
		<?= $content; ?>
		
		</div>
	</body>
</html>