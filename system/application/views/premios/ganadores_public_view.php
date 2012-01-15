<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
Premios >
<?php echo $title ?></p>
<h1 class="titulo center"><?php echo $title ?></h1>

<h3 class="center"><?php echo $premio->descripcion?></h3>
<p class="center"><img src="<?php echo imagen_sponsor($premio->id_sponsor)?>" width="300px" alt="" /></p>

<table>
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Equipo</th>
			<th>Jugador</th>								      
	    </tr>
	    	    </thead>
	    
<?php if (!empty($ganadores)) : ?>
<tbody>
		<?php foreach ($ganadores as $ganador) :?>		
	    <tr>
	    	<td><?php echo $ganador->fecha?></td>
	    	<td><?php echo $ganador->equipo?></td>
	    	<td><?php echo $ganador->jugador?></td>
		</tr>   			
		<?php endforeach; ?>
<?php else : ?>		
	<tr><td>No hay premios registrados</td></tr>
</tbody>
<?php endif ?> 

</table>  

    
</body>
</html>