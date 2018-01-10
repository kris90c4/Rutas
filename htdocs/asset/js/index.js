// VALIDACIONES Registrar

//Al perder el foco el correo, se valida si ya existe
$("#registrar input[name=mail]").blur(function(){
	// Se postea, si responde, existe el correo
	$.post("?controller=registrar&action=checkMail",{
		mail: $(this).val()
	},
	function(data){
		//Si existe el correo se le aplica foco de nuevo y se abre un dialogo
		if(data){
			$("#registrar input[name=mail]").focus();
			$("#validation").html(data).dialog();
		}
	})
});
// Validacion de confirmar contraseña
$("#registrar input[name=pass]").blur(function(){
	$("#registrar input[name=cpass]").attr("pattern",$(this).val());
});

// Gestion Usuarios

$("#gestionUsuarios .reset").click(function(){
	boton=$(this);
	$.post(
		"?controller=perfil&action=resetPass",
		{
			id: $(this).prev().val()
		},
		function(data){
			if(data){
				$('#errorGestion').html(data).dialog();
				boton.addClass("btn-danger");
			}else{
				boton.addClass("btn-success");
			}
		}
	);
});
$("#gestionUsuarios .del").click(function(){
	boton=$(this);
	$.post(
		"?controller=perfil&action=delUser",
		{
			id: $(this).prev().prev().val(),
			admin: $(this).parents("tr").find("td:nth-child(5)").html()
		},
		function(data){
			if(data=="No puedes eliminar un administrador"){
				boton.addClass("btn-danger");
				$('#errorGestion').html(data).dialog();
			}else if(data){    
				$('#errorGestion').html(data).dialog();
			}else{
				boton.parents("tr").remove();
			}
		}
	);
});

$("#gestionUsuarios").DataTable();

//Agenda

$("#agenda").DataTable();

//HOTFIX: Se posiciona el puntero al final del texto(ARREGLAR)
function aMays(e, elemento) {
	tecla=(document.all) ? e.keyCode : e.which;
	elemento.value = elemento.value.toUpperCase();
}

// Información nuevo compraventa
$('#info_gestion').on('click',function(){
	swal('Para calcular el precio de la gestión', 'Hay que restar 58€ al total del traspaso<br>Por ejemplo, Rollandi paga 85€ por traspaso, al restarle 58€(Que son las tasas fijas), el coste de la gestión se queda en 27€','info');
});


function keyOff(){
	return false;
}




/*MODAL*/


var modal = function(){
	var method = {},
	$overlay,
	$modal,
	$content,
	$close;

	// Center the modal in the viewport
	method.center = function () {
		var top, left;

		top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
		left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;

		$modal.css({
			top:top + $(window).scrollTop(),
			left:left + $(window).scrollLeft()
		});
	};

	// Open the modal
	method.open = function (settings) {
		$content.empty().append(settings.content);
		$content.addClass(settings.class);
		$content.attr('id',settings.id);
		$modal.css({
			width: settings.width || 'auto',
			height: settings.height || 'auto'
		});

		method.center();
		$(window).on('resize.modal', method.center);
		$modal.show();
		$overlay.show();
	};

	// Close the modal
	method.close = function () {
		$modal.remove();
		$overlay.remove();
		//$content.empty();
		$(window).off('resize.modal', method.center);

	};

	// Generate the HTML and add it to the document
	$overlay = $('<div id="overlay"></div>');
	$modal = $('<div id="modal"></div>');
	$content = $('<div id="content"></div>');
	$close = $('<a id="close" class="glyphicon glyphicon-remove" href="#"></a>');

	$modal.hide();
	$overlay.hide();
	$modal.append($content, $close);

	$(document).ready(function(){
		$('body').append($overlay, $modal);						
	});

	$overlay.click(function(){
		method.close();
	});

	$close.click(function(e){
		e.preventDefault();
		method.close();
	});

	return method;

};

// Wait until the DOM has loaded before querying the document

$(document).ready(function(){

	/*$.get('ajax.html', function(data){
		modal.open({content: data});
	});

	$('a#howdy').click(function(e){
		modal.open({content: "Hows it going?"});
		e.preventDefault();
	});*/
	


});