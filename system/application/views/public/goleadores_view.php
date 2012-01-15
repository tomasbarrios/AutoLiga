<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Goleadores</p>
<h1 class="titulo">Goleadores</h1>
<?php if (!empty($goleadores)) :?>
<table>
	<tbody>
		<tr>
			<th>#</th>       
                        <th>Jugador</th>
			<th>Goles</th>
                        <th>Equipo</th>
	      	</tr>
        	<?php foreach ($goleadores as $posicion => $jugador) :?>
            <tr>
                <td><?php echo ($posicion+1) ?></td>                
                <td><?php echo $jugador->nombre ?></td>
                <td><?php echo $jugador->incidentes ?></td>
                <td><?php echo anchor('equipos/ver/'.$jugador->id_equipo,$jugador->equipo) ?></td>            
			</tr>                
			<?php endforeach; ?>
	</tbody>
</table>
<?php else :?>
<p>No hay goleadores aun.</p>
<?php endif ?>