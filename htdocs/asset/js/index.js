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

var openPhotoSwipe = function(src) {
    var pswpElement = document.querySelectorAll('.pswp')[0];
    // build items array
    var items = new Array();
    for (var i = 0; i < src.length; i++) {
        items[i]={'src': src, w: 0, h: 0};
    }
    // define options (if needed)
    var options = {
             // history & focus options are disabled on CodePen        
        history: false,
        focus: false,
        showAnimationDuration: 0,
        hideAnimationDuration: 0
    };
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.listen('gettingData', function(index, item) {
        if (item.w < 1 || item.h < 1) { // unknown size
            var img = new Image(); 
            img.onload = function() { // will get size after load
            item.w = this.width; // set image width
            item.h = this.height; // set image height
               gallery.invalidateCurrItems(); // reinit Items
               gallery.updateSize(true); // reinit Items
            }
            img.src = item.src; // let's download image
        }
    });
    gallery.init();
};

//Devuelve una promesa que contiene un array con los datos del vehiculo
datosVehiculo = function(matricula){
	return new Promise(function(resolve){
		$.post('?controller=entrada&action=jsonDatosVehiculo',{
			'matricula': matricula
		},function(data){
			values=JSON.parse(data);
			resolve(values);
		});
	});
}
/*$('#datosVehiculo').on('click',function(){
	$.post('?controller=entrada&action=jsonDatosVehiculo',{
		'matricula': $('#matricula').val()
	},function(data){
		info=JSON.parse(data);
		console.log(info);
		console.log(typeof info['error']);
		if(typeof info['error']=='undefined'){
			swal({
				title: '<i>Datos</i>',
				html: 
					'<label for="">Marca: </label><span>'+info['marca']+'</span><br>' +
					'<label for="">Modelo: </label><span>'+info['modelo']+'</span><br>' +
					'<label for="">Cilindrada: </label><span>'+info['cilindrada']+'</span><br>' +
					'<label for="">Bastidor: </label><span>'+info['bastidor']+'</span><br>' +
					'<label for="">Fecha matriculacion: </label><span>'+info['fechaMatri']+'</span><br>'+
					'<label for="">CVf: </label><span>'+info['cvf']+'</span><br><br>',
				customClass: 'datos'
			});
		}else{
			swal(info['error']);
		}
	})
})*/

function preloader(){
	//document.getElementById("loading").style.display = "none";
	//document.getElementById("entrada").style.display = "block";
	document.getElementById("entradas").style.background = "red";
	console.log('cargado');
}//preloader

//$(document).ready(preloader);

$('ul.nav li.dropdown').hover(function() {

  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);

}, function() {

  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);

});