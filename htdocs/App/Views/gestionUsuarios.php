<div>
	<table id="gestionUsuarios">
		<thead>
			<tr>
			<?php foreach (array_keys($usuarios[0])as $value): ?>
				<th><?=ucfirst ($value)?></th>
			<?php endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($usuarios as  $value): ?>
			<tr>
				<input type="hidden" name="id" value="<?= $value['id']; ?>">
				<?php foreach ($value as $key => $value):?>
					<td><?= $value ?></td>
				<?php endforeach;?>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>