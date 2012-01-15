<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('admin','Administracion') ?> > <?php echo $title ?></p>
<h1 class="titulo">
	<?php echo $title ?>
	<span class="opciones"><?php echo anchor('copas/nuevo','[Nueva]');?></span>
</h1>

<table>
	<tr>
		<th>Nombre</th>
		<th>Formato</th>				
		<th>Acciones</th>				
	</tr>
	<?php foreach ($copas as $copa) : ?>
	<tr>
		<td><?php echo anchor('copas/editar/'.$copa->id_campeonato, $copa->nombre); ?></td>		
		<td><?php echo anchor('copas/editar/'.$copa->id_campeonato, $copa->formato); ?></td>
		<td><?= anchor('copas/generar_fixture/'.$copa->id_campeonato, 'Generar Partidos')?></td>
	</tr>
	<?php endforeach; ?>
</table>
