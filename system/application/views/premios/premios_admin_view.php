<script type="text/javascript">
$(document).ready(function(){
	$(':input').change(function(){
		var tr = $(this).closest('tr');
		$.post('<?php echo base_url()?>premios/guardar',
				tr.find(':input').serialize());
	});
});
</script>
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?><span class="opciones"><?php echo anchor('premios/nuevo','Nuevo',"id='add'");?></a></span></h1>

<table>
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Asignar</th>
			<th>Editar</th>
			<th>Descripcion</th>
			<th>Sponsor</th>
			<th>Frecuencia</th>	
			<th>Tipo</th>
			<th></th>					      
	    </tr>
	    	    </thead>
	    
<?php if (!empty($premios)) : ?>
<tbody>
		<?php foreach ($premios as $premio) :?>		
	    <tr id="<?php echo $premio->id_premio?>">
	    	<td><?php echo $premio->nombre?></td>
	    	<td><?php echo anchor('ganadores/ver/'.$premio->id_premio,'Ganadores')?></td>
	    	<td><?php echo anchor('premios/editar/'.$premio->id_premio,'Editar')?></td>
			<td><?php echo $premio->descripcion?></td>
			<td>			
			<?php echo $premio->id_sponsor?></td>
			<td><?php echo $premio->frecuencia?></td>
			<td><?php echo $premio->tipo?></td>	
			<td><?php echo anchor('premios/eliminar/'.$premio->id_premio,'Eliminar')?>							
		</tr>   			
		<?php endforeach; ?>
<?php else : ?>		
	<tr><td>No hay ganadores registrados</td></tr>
</tbody>
<?php endif ?> 

</table>  

    
</body>
</html>