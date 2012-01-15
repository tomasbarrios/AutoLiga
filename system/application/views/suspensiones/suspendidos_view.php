<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Suspendidos</p>
<h1 class="titulo">Suspendidos</h1>
<table>
	<tbody>
		<tr>
			<th>Jugador</th>
			<th>Cant. Fechas</th>
			<th>Fecha</th>
			<th>Equipo</th>			      
	       </tr>
<?php if (!empty($suspensiones)) : ?>
			<?php foreach ($fechas as $fecha) :
				
				if (!empty($suspensiones[$fecha->id_fecha])) :
				
				?>
				<?php foreach ($suspensiones[$fecha->id_fecha] as $key=>$susp) :?>		
			    <tr>
					<td><?php echo $susp['jugador']?></td>
					<td><?php echo $susp['fecha_actual']?>/<?php echo $susp['cant_fechas']?></td>
					<td><?php echo $fecha->nombre?></td>
					<td><?php echo anchor('equipos/ver/'.$susp['id_equipo'],$susp['equipo'])?></td>				
				</tr>   			
				<?php endforeach; ?>
				<?php else : ?>
				<tr>
					<td>No hay suspensiones</td>
					<td>-</td>
					<td><?php echo $fecha->nombre?></td>
					<td>-</td>				
				</tr>
				<?php endif ?>				
		<?php endforeach; ?>
	<?php else : ?>
	<tr><td>No hay suspensiones</td></tr>
<?php endif ?>     
</tbody>
</table>  

</body>
</html>