<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<link rel="icon" href="asset/icons/portol.ico" type="image/x-icon" />
		<!--meta http-equiv="Expires" content="0">
		<meta http-equiv="Last-Modified" content="0">
		<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
		<meta http-equiv="Pragma" content="no-cache"-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ></script>
		<!-- BoootStrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!-- JQuery UI -->
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<!-- Funciones de Ajax -->
		<script type="text/javascript" src="/<?=ASSET?>js/Ajax.js"></script>
		<!-- API DataTables -->
		<link rel="stylesheet" type="text/css" href="/<?=ASSET?>css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="/<?=ASSET?>css/font-awesome.min.css">
		<script type="text/javascript" src="/<?=ASSET?>js/jquery.dataTables.min.js"></script>
		<!-- API TableExport -->
		<script type="text/javascript" src="/<?=ASSET?>js/tableExport.jquery/tableExport.js"></script>
		<script type="text/javascript" src="/<?=ASSET?>js/tableExport.jquery/jquery.base64.js"></script>
		<script type="text/javascript" src="/<?=ASSET?>js/tableExport.jquery/html2canvas.js"></script>
		<script type="text/javascript" src="/<?=ASSET?>js/tableExport.jquery/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript" src="/<?=ASSET?>js/tableExport.jquery/jspdf/jspdf.js"></script>
		<script type="text/javascript" src="/<?=ASSET?>js/tableExport.jquery/jspdf/libs/base64.js"></script>
		<!-- Hoja de estilo -->
		<link rel="stylesheet" type="text/css" href="/<?=ASSET?>css/style.css">
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
		
		<!--script src='https://www.google.com/recaptcha/api.js'></script-->
		
		<!-- jQuery Modal -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
		<!-- JS Comun -->
		<script type="text/javascript" src="/<?=ASSET?>js/index.js"></script>
		<?php //JS por controlador ?>
		<?php if(isset($_GET['controller'])&&file_exists(ASSET."js/".$_GET['controller'].".js")){ ?>
		<script type="text/javascript" src="/<?=ASSET?>js/<?= $_GET['controller'] ?>.js"></script>
		<?php } ?>
	</head>
	<body>
	<?= $full==true?$menu:""; //Variable que contiene el html del menu ?>


		<div id="cuerpo">
		<?= $content; //Variable que contiene el html de la vista a cargar ?>
		
		</div>
		<?= isset($_SESSION['error'])&&$_SESSION['usuario']->getNombre()=="cristian"?var_dump($_SESSION['error']):"" ?>
	</body>

</html>