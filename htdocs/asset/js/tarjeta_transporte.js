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

	// Al clicar sobre
	$('.archivos').on('click',function(){
		var info="";
		id=$(this).parents("tr").find("td:nth-child(1)").html();
		$.post("?controller=tarjeta_transporte&action=fk_imagenes",{"id":id}, function(data){
			console.log(data);
			modal1=new modal();
			if(data){
				src=jQuery.parseJSON(data);
				console.log(src);
				galeria=$('<div>');
				for (var i = 0; i < src.length; i++) {
					var img = new Image();
					img.src = src[i];
					img.height=100;
					img.onclick=function(){
						this.height=500;
						modal1.open({content: galeria});
					}
					galeria.append($('<a href="#" class="img">').append(img));
				}
				modal1.open({content: galeria});
				

				console.log($('img'));
				



				// The tricky part : create a blob url to your image, that you can use anywhere
				//for (var i = 0; i < src.length; i++) {
					/*var objurl = window.URL.createObjectURL(new Blob([data]));
					var img = new Image();
					img.src = objurl;
					var div = document.getElementById("cuerpo");
					div.appendChild(img);
					img.onload = function() {
						console.log('imagen ' + i + 'cargada.');
					}*/
				//}
				//openPhotoSwipe(src);
			}
		});
	})
	
})