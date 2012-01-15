<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo anchor('premios/admin','Premios') ?> >  
<?php echo $premio->nombre ?> >
<?php echo $title ?>
</p>
<h1 class="titulo"><?php echo $title ?><span class="opciones">
<?php echo anchor('ganadores/nuevo/'.$premio->id_premio,'Agregar Ganador');?></a></span></h1>

<table>
	<thead>
		<tr>
			<th></th>
			<th>Fecha</th>
			<th>Equipo</th>
			<th>Jugador</th>
			<th></th>								      
	    </tr>
	    	    </thead>
	    
<?php if (!empty($ganadores)) : ?>
<tbody>
		<?php foreach ($ganadores as $ganador) :?>		
	    <tr>
	    	<td><?php echo anchor('ganadores/editar/'.$ganador->id_ganador_premio,'Editar')?>
	    	<td><?php echo $ganador->fecha?></td>
	    	<td><?php echo $ganador->equipo?></td>
	    	<td><?php echo $ganador->jugador?></td>
	    	<td><?php echo anchor('ganadores/eliminar/'.$ganador->id_ganador_premio,'Eliminar')?>
		</tr>   			
		<?php endforeach; ?>
<?php else : ?>		
	<tr><td>No hay premios registrados</td></tr>
</tbody>
<?php endif ?> 

</table>  

    
</body>
</html>