<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo $title?></p>
<h1 class="titulo"><?php echo $title?>
<span class="opciones"><?php echo anchor('partidos/nuevo','Nuevo Partido');?></span>
</h1>


<?php 
foreach ($fechas as $fecha): 
	foreach ($campeonatos as $campeonato):
		$matchs = array();	
		foreach($partidos as $partido){ 
			if ($fecha->id_fecha == $partido->id_fecha and $campeonato->id_campeonato == $partido->id_campeonato) {
				$matchs[]=$partido;
			}
		}
	

?>
		<?php if (!empty($matchs)) :?>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tbody><tr>
	       <th>Dia</th> 
	       <th></th>      
	       <th>Cancha</th>
	       <th>Grupo</th>            
	       <th colspan="5"><?php echo $campeonato->nombre?> - <?php echo $fecha->nombre?> </th>
	       </tr>
		<?php foreach($matchs as $partido): ?>
			<tr>
				<td width="20%"><?php echo ($partido->fecha_libre == 1) ? date('d/m/Y \-\-\:\-\-',strtotime($partido->fecha)) : date('d/m/Y H:i',strtotime($partido->fecha)) ?></td>
				<td><?php echo anchor('partidos/editar/'.$partido->id_partido,'Editar')?></td>			
				<td width="5%"><?php echo ($partido->fecha_libre == 1)? '-' : $partido->cancha?></td>
				<td><?php echo ($partido->id_grupo==null)? '-': $partido->grupo?></td>
				<td width="25%"><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>
				<td><?php echo ($partido->jugado)? $partido->goles_local :''?></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td><?php echo ($partido->jugado)? $partido->goles_visita :''?></td>
				<td width="25%"><?php echo ($partido->fecha_libre == 1) ? 'Libre' : anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita) ?></td>
			</tr>			
		<?php endforeach ?>
		      
	    </tbody></table>
	    <?php endif ?>
	<?php endforeach ?>    
<?php endforeach ?>

              

</body>
</html>