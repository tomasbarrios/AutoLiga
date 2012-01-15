<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo $title ?></p>
<h1 class="titulo">
	<?php echo $title ?>
	<span class="opciones"><?php echo anchor('grupos/nuevo','[Nuevo]');?></span>
</h1>

<table>
	<tr>
		<th>Nombre</th>	
		<th>Fase</th>						
	</tr>
	<?php foreach ($grupos as $grupo) : ?>
	<tr>
		<td><?php echo anchor('grupos/editar/'.$grupo->id_grupo, $grupo->nombre); ?></td>
		<td><?= !empty($grupo->id_fase) ? $fases[$grupo->id_fase] : 'Ninguna!'?></td>
	</tr>
	<?php endforeach; ?>
</table>