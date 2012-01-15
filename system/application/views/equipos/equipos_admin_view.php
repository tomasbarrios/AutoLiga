<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('admin','Administracion') ?> > Equipos</p>
<h1 class="titulo">Equipos
<span class="opciones"><?php echo anchor('equipos/nuevo','[Nuevo]');?></span>
</h1>

<p class="box">
<? if($league_settings->inscripciones_abiertas == 1):?>
    Inscripciones Abiertas,  <a href="/inscripcion/cerrar">Cerrar</a>
<? else : ?>
    Inscripciones Cerradas, <a href="/inscripcion/abrir">Abrir</a>
<? endif ?>
</p>

    <table>
    	<thead>
    		<th>Nombre</th>
			<th>Grupo</th>      
			<th>Capitan</th>
			<th>Email</th>
			<th></th>
    	</thead>
    	
    <?php foreach($equipos as $equipo) : ?>        
        <tr>
            <td><?php echo anchor('equipos/editar/'.$equipo->id_equipo,$equipo->nombre); ?></td>
            <td><?php echo (!empty($equipo->grupo)? $grupos[$equipo->grupo] : '-'); ?></td>
            <td><?= empty($capitanes[$equipo->id_equipo])? '-' : $capitanes[$equipo->id_equipo]->nombre?></td>
            <td><?= empty($capitanes[$equipo->id_equipo])? '-' : $capitanes[$equipo->id_equipo]->email?></td>
			<td>
				<?php echo anchor('equipos/eliminar/'.$equipo->id_equipo,'Eliminar'); ?>
				<? if($equipo->activo): ?>
					<?= anchor('equipos/desactivar/'.$equipo->id_equipo, 'Desactivar')?>
				<? else: ?>
					<?= anchor('equipos/activar/'.$equipo->id_equipo, 'Activar')?>
				<? endif ?>
			</td>
		</tr>    
    <?php endforeach;?>
    </table>

   