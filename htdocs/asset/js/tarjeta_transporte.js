$(document).ready(function(){
	$('#registro tfoot th').each( function () {
	    var title = $(this).text();
	    $(this).html( '<input type="text" placeholder="'+title+'" />' );
	} );
	// Aplica la api de DataTable a la tabla con Id $vista
	//se aplica un retardo para asugurar la aplicacion del seleccionado



	var table2 = $('#registro').DataTable({
	    "order": [[ 0, "desc" ]],
	});
		
	// Aplica el buscador
	table2.columns().every( function () {
	    var that = this;
	    $( 'input', this.footer() ).on( 'keyup change', function () {
	        if ( that.search() !== this.value ) {
	            that
	                .search( this.value )
	                .draw();
	        }
	    });
	});

	$('#nuevaTarjeta').on('click',function(e){
		e.preventDefault();
		modal2=new modal();
		$.post("?controller=tarjeta_transporte&action=create", function(htmlexterno){
			modal2.open({content: htmlexterno,id:'plantilla'});
		});
	});
	$('.edit').on('click',function(){
		modal1=new modal();
		id=$(this).parents("tr").find("td:nth-child(1)").html()
		console.log(id);
		$.post("?controller=tarjeta_transporte&action=editar",{"id":id}, function(htmlexterno){
			modal1.open({content: htmlexterno,id:"plantilla"});
		});
	});
})