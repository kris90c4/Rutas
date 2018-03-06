$(document).ready(function(){

	//$('#presupuesto').width();
	//$(window).width();
	$('#presupuesto').css('left',($(window).width()-$('#presupuesto').width())/2);
	//$('#presupuesto').css('color','red');
	$('#coche').on('click',function(){
		//$(this).html($('<img src="asset/gifs/ajax-loader (1).gif">'));
		if(typeof ajax1 !== 'undefined'){
			ajax1.abort();
		}
		crono(true);
		ajax1=$.post('?controller=entrada&action=find620',{
			"matricula": $('#matricula').val()
			//."precio": $('#inicial').val()
		},function(data){
			//console.log(data);
			info=JSON.parse(data);
			//console.log(info);
			rellenar(info);
			//$('#620').html('620');
			crono(false);
			$('#nuevo').css('visibility','visible');
			save(info,'coche');
		});
	});
	function save(info,tipo){
		info['fecha_matriculacion']=info['fechaMatri'];
		info['base_imponible']=info['precio'];
		info['tipo_gravamen']=info['cuota']/info['precio']*100;
		info['tipo']=tipo;
		json=JSON.stringify(info);
		$.post('?controller=presupuesto&action=save',{
			'json':json
		},function(data){
			console.log(data);
		});
	}
	$('#correo').on('click',function(){
		$.post('?controller=presupuesto&action=correo',{
			'html':$('#cuerpo').html()
		},function(data){
			swal('Presupuesto',data);
		})
	})
	$('#moto').on('click',function(){
		//$(this).html($('<img src="asset/gifs/ajax-loader (1).gif">'));
		/*if(typeof ajax1 !== 'undefined'){
			ajax1.abort();
		}*/
		crono(true);
		datosVehiculo($('#matricula').val()).then(function(info){
			cilindrada=parseInt(info['cilindrada']);
			d=info['fechaMatri'].split('/');
			fechaMatri = new Date(d[2],d[1]-1,d[0]);

			years=antiguedad(fechaMatri);
			console.log(years);

			info['precio']=valorMoto(cilindrada, years);
			info['cuota']=info['precio']*0.04;

			//info['base_imponible']=info['precio'];

			//console.log(info);
			rellenar(info);
			//$('#620').html('620');
			crono(false);
			$('#moto').attr('disabled','true');
			$('#coche').attr('disabled','true');
			$('#nuevo').css('visibility','visible');
			save(info,'moto');
		})
		/*ajax1=$.post('?controller=entrada&action=jsonDatosVehiculo',{
			"matricula": $('#matricula').val()
			//."precio": $('#inicial').val()
		},function(data){
			//console.log(data);
			info=JSON.parse(data);
			cilindrada=parseInt(info['cilindrada']);
			d=info['fechaMatri'].split('/');
			fechaMatri = new Date(d[2],d[1]-1,d[0]);

			years=antiguedad(fechaMatri);
			console.log(years);

			info['precio']=valorMoto(cilindrada, years);
			info['cuota']=info['precio']*0.04;
			
			console.log(info);
			rellenar(info);
			//$('#620').html('620');
			crono(false);
		})*/
	});

	$('#nuevo').on('click',function(){
		console.log($('#marca').text());
		if($('#marca').text()!=""){
			location.reload();
		}
	});

	// PD: probar de conseguir un año con decimales
	
	// Se introduce un objeto date y devuelve la cantidad de años enteros truncados
	function antiguedad(fechaMatri){

		hoy = new Date();
		console.log( new Date(fechaMatri-hoy));
		years= hoy.getYear()-fechaMatri.getYear();
		meses= hoy.getMonth()-fechaMatri.getMonth();
		dias= hoy.getDate()-fechaMatri.getDate();
		console.log(hoy.getDate()-fechaMatri.getDate(),hoy.getMonth()-fechaMatri.getMonth() ,hoy.getYear()-fechaMatri.getYear());
		// comprueba que los meses sean anteriores al actual para poder contar el año entero o restarlo
		if(hoy.getMonth()>fechaMatri.getMonth()){
			//console.log('Años:', years);
		}else if(hoy.getMonth()==fechaMatri.getMonth()){
			//console.log('Mismo mes');
			if(hoy.getDate()>=fechaMatri.getDate()){
				//console.log('Años:' , years)
			}else{
				console.log('resta');
				years--;
			}
		}else{
			console.log('resta');
			years--;
		}
		return years;
	}


	$('#last').on('click',function(){
		$.post('?controller=entrada&action=ultimoResultado',function(data){
			if(data!='false'){
				info=JSON.parse(data);
				$('#matricula').val('');
				rellenar(info);
				$('#nuevo').css('visibility','visible');
			}else{
				swal('No se ha realizado ninguna busqueda');
			}
		})
	})

	function rellenar(info){
		if(typeof info['error']=='undefined'){
			$('#marca').text(info['marca']);
			$('#modelo').text(info['modelo']);
			$('#cilindrada').text(info['cilindrada']);
			$('#bastidor').text(info['bastidor']);
			$('#fechaMatri').text(info['fechaMatri']);
			$('#cvf').text(info['cvf']);

			$('#base_imponible').text(info['precio']+" €");
			$('#cuota').text(info['cuota']+" €");
			$('#tipo').text(Math.round(info['cuota']/info['precio']*100)+'%');
			$('#total').text(info['cuota']+121+" €");
			$('#gestion').text('60 €');
			$('#otros').text('3 €');
			$('#trafico').text('58 €');
			matricula=$('#matricula').val();
			if(matricula==""){
				matricula=info['matricula'];
			}
			$('#matricula').replaceWith('<span>'+ info['matricula']+'</span>');
			//$('#620').remove();
		}else{
			swal(info['error']);
		}
	}

	function crono(estado){
		if(typeof crono2 !== 'undefined'){
			clearInterval(crono2);
		}
		if(estado==true){
			i=0;
			$('#crono').css('background','#ddd');
			crono2=setInterval(function(){
				$('#crono').text(i+'s');
				if(i==30){
					$('#crono').css('background','green');
				}else if(i==50){
					$('#crono').css('background','yellow');
				}else if(i==70){
					$('#crono').css('background','red');
				}
				i++;
				
			},1000)
		}else{
			clearInterval(crono2);
			//$('#620').html('620');
		}
	}
	function valorMoto(cilindrada, years){
		if(cilindrada>50 && cilindrada <=75){
			valor=750;
		}else if(cilindrada>75 && cilindrada <=125){
			valor=1100;
		}else if(cilindrada>125 && cilindrada <=150){
			valor=1200;
		}else if(cilindrada>150 && cilindrada <=200){
			valor=1300;
		}else if(cilindrada>200 && cilindrada <=250){
			valor=1500;
		}else if(cilindrada>250 && cilindrada <=350){
			valor=2200;
		}else if(cilindrada>350 && cilindrada <=450){
			valor=2700;
		}else if(cilindrada>450 && cilindrada <=550){
			valor=3000;
		}else if(cilindrada>550 && cilindrada <=750){
			valor=5000;
		}else if(cilindrada>750 && cilindrada <=1000){
			valor=7500;
		}else if(cilindrada>1000 && cilindrada <=1200){
			valor=9500;
		}else if(cilindrada>1200){
			valor=12000;
		}
		switch(years){
			case 1:
				v=100;
				break;
			case 2:
				v=84;
				break
			case 3:
				v=56;
				break
			case 4:
				v=47;
				break
			case 5:
				v=39;
				break
			case 6:
				v=34;
				break
			case 7:
				v=28;
				break
			case 8:
				v=24;
				break
			case 9:
				v=19;
				break
			case 10:
				v=17;
				break
			case 11:
				v=13;
				break
			default:
				v=10;
				break
		}
		return valor*v/100;
	}
});