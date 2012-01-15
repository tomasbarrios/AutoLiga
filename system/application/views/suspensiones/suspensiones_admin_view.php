<script type="text/javascript">
$(document).ready(function(){
	$("input").change(function(){
		tr = $(this).closest('tr');
		activada = tr.find(":checkbox[name='activada']");
		cant_fechas = tr.find("input[name='cant_fechas']").val();
		id_suspension = tr.attr('id');	
		$.post('<?php echo base_url();?>suspensiones/update',
				{activada: activada.is(':checked'), 
				id_suspension: id_suspension, 
				cant_fechas: cant_fechas}
				);
	});
});
</script>
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>
<?php if (!empty($suspensiones)) : ?>
<table>
	<tbody>
		<tr>
			<th>Activa</th>
			<th>Jugador</th>
			<th>Cant. Fechas</th>
			<th>Fecha</th>
			<th>Equipo</th>			      
	       </tr>

				<?php foreach ($suspensiones as $susp) :?>		
			    <tr id="<?php echo $susp->id_suspension?>">
			    	<td><input type="checkbox" name="activada" value="j"  <?php echo set_checkbox('activada', 'j', ($susp->activada==1) ? $susp->activada == 1 ? TRUE : FALSE : FALSE )?>></td>
					<td><?php echo $susp->jugador?></td>
					<td><input type="text" name="cant_fechas" class="small" value="<?php echo $susp->cant_fechas?>"></td>
					<td><?php echo $susp->fecha_suspension?></td>
					<td><?php echo anchor('equipos/editar/'.$susp->id_equipo,$susp->equipo)?></td>				
				</tr>   			
				<?php endforeach; ?>
				
			
</tbody>
</table>  
<input type="button" value="Guardar Cambios" onClick="window.location.href='<?= site_url('admin') ?>';" />
<?php else : ?>
	<p>No hay suspensiones</p>
<?php endif ?>   

</body>
</html>