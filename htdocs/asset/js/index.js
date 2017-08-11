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