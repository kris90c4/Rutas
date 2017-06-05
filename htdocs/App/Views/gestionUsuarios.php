<div>
	<table id="gestionUsuarios">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Correo</th>
				<th>Tipo</th>
				<th>Fecha de la ultima visita</th>
				<th>Fecha de registro</th>
				<th>ID</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($usuarios as  $usuario): ?>
			<tr>
				<td><?= $usuario[''] ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>