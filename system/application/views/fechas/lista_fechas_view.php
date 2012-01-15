
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('admin','Administracion') ?> > <?php echo $title ?></p>
<h1 class="titulo">
	<?php echo $title ?>
	<span class="opciones"><?php echo anchor('fechas/nuevo','[Nueva]');?></span>
</h1>
<?php if (empty($fechas)): ?>
<p>No hay fechas registradas</p>
<?php else : ?>
<table>
	<tr>
		<th>Nombre</th>
		<th>Campeonato</th>
		<th>Dia</th>			
	</tr>
	<?php foreach ($fechas as $fecha) : ?>
	<tr>
		<td><?php echo anchor('fechas/editar/'.$fecha->id_fecha, $fecha->nombre); ?></td>
		<td><?php echo $campeonatos[$fecha->id_campeonato] ?></td>		
		<td><?php echo date('d/m/Y H:i',strtotime($fecha->dia)); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif ?>