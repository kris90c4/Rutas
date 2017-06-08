<?php defined("APPPATH") OR die("Acceso denegado"); ?>
<div>
	<table id="gestionUsuarios">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Correo</th>
				<th>Tipo</th>
				<th>Fecha ultima visita</th>
				<th>Fecha registro</th>
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