<?php
namespace App\Controllers;
defined("APPPATH") OR die("Acceso denegado");


use \Core\View,
	\App\Models\Tarjeta_transporte as tj,
	\App\Models\Cliente as ClienteM,
	\App\Models\Archivo as ArchivoM;

class Tarjeta_transporte extends ControllerBase{
	//Carga la pagina principal de la aplicacion
	public function view(){
		View::set("title","Tarjetas de transporte");
		View::set("registros",tj::getView());
		View::render('tarjetas_transporte');
	}
	public function create($id=0,$editar=array()) {
		View::set('title',"Nueva Tarjeta Transporte");
		if($id>0){
			view::set('editar',$editar);
			//view::set('id',"plantilla");
		}
		View::render("nueva_tarjeta_transporte",false);
	}
	public function save() {
		try{
			if (isset($_POST['enviar'])){

				extract($_POST);

				$this->log("Creando tarjeta transporte... Matricula: $matricula - Gestionado por ". $_SESSION['usuario']->getNombre());

				//Se recopilan todos los datos necesarios para almacenarlos en la base de datos
				$datos_cliente=array('nombre'=> $cliente, 'mail'=> $mail, 'telefono'=> $tlf);
				$this->tratamiento_datos_cliente($datos_cliente);
				$values=$_POST;
				$values['matricula']=strtoupper($matricula);
				$values['id_cliente']=$this->id_cliente($datos_cliente);

				//Calculo, duracion del proceso.
				$a=new \DateTime();
				$antes=$a->createFromFormat('Y-m-d H:i:s',$tiempo);
				$ahora=new \DateTime();
				$dif=$ahora->diff($antes);
				$values['tiempo']=$dif->format("%H:%I");
				
				$values['id_usuario']=$_SESSION['usuario']->getId();
				
				//Se abre una transaccion para poder echar para atras en caso de haber algun error antes de terminar
				$con=\Core\Database::instance();
				$con->beginTransaction();
				
				$respuesta=Tj::insert($values);

				//Se elimina el array intermedio que no sirve
				$archivos=$_FILES;
				$archivos=$archivos['archivos'];
				try{
					//throw new \Exception("error de prueba");
					if(isset($archivos)&&!empty($archivos)){
						$cantidad=count($archivos['name']);
						for ($i=0; $i < $cantidad; $i++) {
							$archivo[$i]['name']=$archivos['name'][$i];
							$archivo[$i]['type']=$archivos['type'][$i];
							$archivo[$i]['tmp_name']=$archivos['tmp_name'][$i];
							$archivo[$i]['size']=$archivos['size'][$i];
							$archivo[$i]['fk']=$respuesta;
							ArchivoM::insert($archivo[$i]);
						}
					}
					$con->commit();
				}catch(\Exception $e){
					$con->rollBack();
					//throw new \Exception($e->getMessage());
					throw $e;
				}


				//var_export($respuesta);
				//exit();
				/////////////////////PENDIENTE. CONTINUAR POR AQUI  ////////////////
				ob_start();
				print "Formulario: \n";
				var_export($values);
				$error= ob_get_contents();
				ob_end_clean();

				if(substr($respuesta, 0, 5) == "Error"){
					$this->log("Tarjeta transporte: $respuesta\n$error");

					View::set("error","Ha ocurrido un error.$error");
					View::set('title',"Nueva entrada");
					View::render("tarjeta_transporte");
				}else{
					$this->log("Tarjeta transporte OK");
					header('location: ?controller=tarjeta_transporte');
				}
				

			}
		}catch(Exception $e){
			$this->log("Error:" . $e->getMessage());
		}
	}
	//Cuando se requiera editar datos, se llama para recuperar los datos actuales
	public function editar() {
		extract($_POST);
		$datos=Tj::getById($id);
		$cliente=ClienteM::getById($datos['id_cliente']);
		$datos['cliente']=$cliente['nombre'];
		$datos['mail']=$cliente['mail'];
		$datos['tlf']=$cliente['telefono'];
		
		$this->create($datos['id'],$datos);
	}


	//Una vez editada la informacion se trata y se guarda de nuevo en la base de datos
	public function editado(){
		if (isset($_POST['editar'])){

			extract($_POST);

			$matricula=strtoupper($matricula);

			$this->log("Editando tarjeta transporte... Matricula: $matricula - Gestionado por ". $_SESSION['usuario']->getNombre());

			$datos=$_POST;
			//Se recopilan todos los datos necesarios para almacenarlos en la base de datos
			$datosCliente=array('id'=>$id_cliente,'nombre'=> $cliente, 'mail'=> $mail, 'telefono'=> $tlf);
			
			$this->tratamiento_datos_cliente($datosCliente);
			
			$datos['matricula']=$matricula;
			$datos['id_cliente']=$this->actualizar_cliente($datosCliente);
			$datos['id_usuario']=$_SESSION['usuario']->getId();
			$datos['id']=$id;
			$tarjetaUpdate=Tj::update($datos);

			if($tarjetaUpdate==1){
				$this->log("Tarjeta transporte modificada OK");
				header('location: ?controller=tarjeta_transporte');
			}else{
				$this->log("Error: ".$tarjetaUpdate);
			}
		}
	}
	
	//Funcion de prueba para visualizar archivos BLOB de MYSQL
	public function ver_archivo($id){

		$archivo=ArchivoM::getById($id);
		//var_export($archivo);
		//exit();
		extract($archivo);
		//echo '<img src="data:image/png;base64,' . base64_encode( $contenido ) . '" />';
		header("Content-type: $tipo");
		print $contenido;
	}

	public function envio_mail_renovacion(){
		$envio=false;
		$lista=array();
		$tarjeta=Tj::getAll();
		$hoy=date('Y-m');

		//menos 1 mes
		$month = new \DateInterval( "P1M" );
		$month->invert = 1; //Make it negative. 
		
		$total=count($tarjeta);
		//Recorre todos las tarjetas de transporte
		for ($i=0; $i < $total; $i++) {
			//Si esta vacia la fecha de renovacion no se envia
			if(!empty($tarjeta[$i]['fecha_vencimiento'])){
				$proximo=new \DateTime($tarjeta[$i]['fecha_vencimiento']);
				$proximo->add($month);
				if($hoy==$proximo->format('Y-m')){
					$envio=true;
					$caduca=new \DateTime($tarjeta[$i]['fecha_vencimiento']);
					//Enviar mail al cliente
					$cliente=ClienteM::getById($tarjeta[$i]['id_cliente']);
					//$cliente['nombre']=ucwords(strtolower($cliente['nombre'])," ");
					$this->mandar_mail($cliente['mail'],'Gestoria Portol le informa de que a comenzado el periodo de renovacion de su tarjeta de transporte', "Buenos dias señor\a $cliente[nombre]<br><br>Le informamos que el proximo dia ". $caduca->format("d-m-Y") ." caduca su tarjeta de transporte.<br><br>Durante este mes esta disponible la renovacion de su tarjeta de transporte. Si desea realizar la renovación con nosotros puede contestar a este mismo correo.");
					$lista[]=array("id"=>$tarjeta[$i]['id'],"cliente"=>$cliente['nombre'],"telefono"=>$cliente['telefono'],"mail"=>$cliente['mail'],"matricula"=>$tarjeta[$i]['matricula'],"fecha_vencimiento"=>$tarjeta[$i]['fecha_vencimiento']);
				}
			}
		}
		//Si se ha encontrado algun cliente
		if($envio){
			$fila="";
			for ($k=0; $k < count($lista); $k++) { 
				$fila.="<tr><td>".$lista[$k]['id']."</td><td>".$lista[$k]['matricula']."</td><td>".$lista[$k]['cliente']."</td><td>".$lista[$k]['telefono']."</td><td>".$lista[$k]['mail']."</td><td>".$lista[$k]['fecha_vencimiento']."</td></tr>";
			}
			$tabla="<table>
				<thead>
					<tr>
						<th>id</th><th>Matricula</th><th>Cliente</th><th>Telefono</th><th>Mail</th><th>Fecha caducidad</th>
					</tr>
				</thead>
				<tbody>
					$fila
				</tbody>
			</table>";
			//myrna@gestoriaportol.com
			$this->mandar_mail('cristiansmx2a@gmail.com',"Notificación Gestoria Pórtol","Para los clientes listados ha comenzado el periodo de renovación de sus tarjetas de transporte<br><br>$tabla");
		}
	}
}
