<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- BoootStrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!-- JQuery UI -->
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<!-- Hoja de estilo -->
		<link rel="stylesheet" type="text/css" href="/<?=ASSET?>css/style.css">
		<!-- Funciones de Ajax -->
		<script type="text/javascript" src="/<?=ASSET?>js/Ajax.js"></script>
		<!-- API DataTables -->
		<link rel="stylesheet" type="text/css" href="/<?=ASSET?>css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="/<?=ASSET?>css/font-awesome.min.css">
		<script type="text/javascript"src="/<?=ASSET?>js/jquery.dataTables.min.js"></script>
		<script type="text/javascript"src="/<?=ASSET?>js/tableExport.jquery/tableExport.js"></script>
		<script type="text/javascript"src="/<?=ASSET?>js/tableExport.jquery/jquery.base64.js"></script>
		<script type="text/javascript"src="/<?=ASSET?>js/tableExport.jquery/html2canvas.js"></script>
		<script type="text/javascript"src="/<?=ASSET?>js/tableExport.jquery/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript"src="/<?=ASSET?>js/tableExport.jquery/jspdf/jspdf.js"></script>
		<script type="text/javascript"src="/<?=ASSET?>js/tableExport.jquery/jspdf/libs/base64.js"></script>
		
		
	</head>
	<body>
	<?= $menu; ?>


		<div id="cuerpo">
		<?= $content; ?>
		
		</div>
		<script type="text/javascript" src="/<?=ASSET?>js/index.js"></script>
	</body>

</html>