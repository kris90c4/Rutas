<?php defined("ADMIN") OR die("Access denied"); ?>
<div>
	<table id="gestionUsuarios">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Correo</th>
				<th>Tipo</th>
				<th>Fecha de la ultima visita</th>
				<th>Fecha de registro</th>
				<th>Acciones</th>
				
			</tr>
		</thead>
		<tbody>
			<?php foreach ($usuarios as  $usuario): ?>
			<tr>
				<td><?= $usuario->getId() ?></td>
				<td><?= $usuario->getNombre() ?></td>
				<td><?= $usuario->getApellidos() ?></td>
				<td><?= $usuario->getMail() ?></td>
				<td><?= $usuario->getAdmin() ?></td>
				<td><?= $usuario->getFechaEntrada() ?></td>
				<td><?= $usuario->getFechaRegistro() ?></td>
				<td>
					<input type="hidden" value="<?= $usuario->getId() ?>">
					<button class="reset btn">Resetear Pass</button>
					<button class="del btn">Eliminar</button>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="errorGestion"></div>
</div>

<script type="text/javascript">
	$(".reset").click(function(){
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
	$(".del").click(function(){
		boton=$(this);
		$.post(
			"?controller=perfil&action=delUser",
			{
				id: $(this).prev().prev().val()
			},
			function(data){
				if(data){
					$('#errorGestion').html(data).dialog();
				}else{
					boton.parents("tr").remove();
				}
			}
		);
	});
</script>