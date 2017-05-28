		<table class="table">
 
			<thead>
				<tr>
					<th>
						Id
					</th>
					<th>
						Nombre
					</th>
					<th>
					<?php var_dump($users);?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user):?>
				<tr>
					<td><?php echo $user["nombre"] ?></td>
					<td><?php echo $user["apellidos"] ?></td>
					<td><?php echo $user["mail"] ?></td>
					<td><?php echo $user["contraseña"] ?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
