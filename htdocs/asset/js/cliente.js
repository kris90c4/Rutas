$(document).ready(function(){

	$(".del").click(function(){
		boton=$(this);
		$.post(
			"?controller=cliente&action=del",
			{
				id: $(this).parents("tr").find("td:nth-child(1)").html(),
			},
			function(data){
				if(data){
					swal(data);
				}else{
					boton.parents("tr").remove();
				}
			}
		);
	});
})