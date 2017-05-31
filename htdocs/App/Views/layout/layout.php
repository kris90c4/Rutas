<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" type="text/css" href="../asset/css/style.css">
		<link rel="stylesheet" type="text/css" href="/<?=$asset?>css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="/<?=$asset?>css/font-awesome.min.css">
		<script type="text/javascript" src="/<?=$asset?>js/index.js"></script>
		<script type="text/javascript" src="/<?=$asset?>js/Ajax.js"></script>
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/jquery.dataTables.min.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/tableExport.jquery/tableExport.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/tableExport.jquery/jquery.base64.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/tableExport.jquery/html2canvas.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/tableExport.jquery/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/tableExport.jquery/jspdf/jspdf.js"></script>
		<script type="text/javascript"src="/<?=$asset?>js/tableExport.jquery/jspdf/libs/base64.js"></script>
		
		
	</head>
	<body>
	<?= $menu; ?>


		<div id="cuerpo">
		<?= $content; ?>
		
		</div>
	</body>
</html>