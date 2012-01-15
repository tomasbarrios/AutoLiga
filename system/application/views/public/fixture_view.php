<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Fechas</p>
<h1 class="titulo">Fechas</h1>

<?php foreach ($fechas as $fecha): 	
	foreach ($grupos as $grupo):
?>
<table>
      <tbody><tr>
       <th>Dia</th>
       <th>Cancha</th>
       <th colspan="3"><?php echo 'Fecha '.$fecha->id_fecha.' - Grupo '.$grupo->grupo?> </th>
       </tr>
	<?php foreach($partidos as $row): ?>
		<?php if ($fecha->id_fecha == $row->id_fecha && $row->grupo == $grupo->grupo): ?>
			<?php if( $row->cancha == 0 ) : ?>
		<tr>
			<td width="20%"></td>
			<td width="10%"></td>
			<td width="30%">Libre: <?php echo anchor('equipos/ver/'.$row->id_equipo_local,$row->local)?></td>
			<td width="10%"></td>
			<td width="30%"></td>
		</tr>
			<?php else :
			?>
			
		<tr>
			<td width="25%"><?php echo date('j/n/Y H \\h\r\s',strtotime($row->fecha)) ?></td>
			<td width="5%"><?php echo $row->cancha?></td>
			<td width="30%"><?php echo anchor('equipos/ver/'.$row->id_equipo_local,$row->local)?></td>
			<td width="10%">vs</td>
			<td width="30%"><?php echo anchor('equipos/ver/'.$row->id_equipo_visita,$row->visita) ?></td>
		</tr>
			<?php endif ?>
		<?php endif ?>
	<?php endforeach ?>
	      
    </tbody></table>

<?php endforeach ?>
<?php endforeach ?>

       

</body>
</html>