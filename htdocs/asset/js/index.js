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