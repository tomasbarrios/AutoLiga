<script type="text/javascript">
$(document).ready(function(){
	$('#id_equipo').change(function(){
		$('#id_jugador').after('<div class="loading"></div>');
		$.post('<?php echo base_url()?>equipos/get_jugadores',
				{id_equipo: $('#id_equipo').val()},
				function(data){
						var options = $('#id_jugador');
						options.empty();
						$.each(data, function(item,value) {
					        options.append($("<option />").val(item).text(value));
					    });
					    $('.loading').remove();
					},
				"json");
	});
});
</script>
<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo anchor('premios/admin','Premios') ?> >
<?php echo anchor('ganadores/ver/'.$id_premio,$premio->nombre) ?> >    
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>
<?php echo form_open('ganadores/guardar')?>
 <input type="hidden" name="id_ganador_premio" value="<?php echo set_value('id_ganador_premio',empty($ganador->id_ganador_premio)? '' : $ganador->id_ganador_premio)?>"/>
 <?php echo form_error('id_ganador_premio')?>
<input type="hidden" name="id_premio" value="<?php echo set_value('id_premio',empty($id_premio)? '' : $id_premio)?>"/>
	
	<?php echo form_error('id_premio'); ?>

<?php if($premio->frecuencia == 'semanal'): ?>
<p>
	<label for="fecha">Fecha</label> 
	<?php echo form_dropdown('id_fecha',$fechas,set_value('id_fecha',isset($ganador->id_fecha) ? $ganador->id_fecha : '')); ?>
	<?php echo form_error('id_fecha'); ?>
</p>
<?php endif ?>
<p>
	<label for="equipo">Equipo</label> 
	<?php echo form_dropdown('id_equipo',$equipos,set_value('id_equipo',isset($ganador->id_equipo) ? $ganador->id_equipo: ''),"id='id_equipo'"); ?>
	<?php echo form_error('id_equipo'); ?>
</p>
<?php if($premio->tipo == 'jugador'):?>
<p>
	<label for="jugador">Jugador</label> 
	<?php echo form_dropdown('id_jugador',$jugadores,set_value('id_jugador',isset($ganador->id_jugador) ? $ganador->id_jugador: ''),"id='id_jugador'"); ?>
	<?php echo form_error('id_jugador'); ?>
</p>
<?php endif ?>


<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close()?>