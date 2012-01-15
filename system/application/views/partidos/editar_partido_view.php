<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"> 
$(document).ready(function(){	
	libre();
	
	function libre () {
		if ($('#libre').is(':checked')) { 
			$('#visita').closest('p').hide('slow');
			$('#cancha').closest('p').hide('slow');
			$('#visita').attr('disabled', true).val('');			
			$('#cancha').attr('disabled', true).val('');
		} else {
			$('#visita').removeAttr('disabled').closest('p').show('slow');
			$('#cancha').removeAttr('disabled').closest('p').show('slow');			
		}
	}
	$('#libre').change(function (){
		libre();
	});
	$("select[name='id_fecha']").change(function(){
		var id_fecha = $(this).val();
		$.post('<?php echo base_url()?>fechas/get_dia',
			{id_fecha: id_fecha},
			function(data){
				$("input[name='fecha']").val(data);
		});
	});

	$('#grupo').change(function(){
		$('#local').after('<span class="loading"></span>');
		$('#visita').after('<span class="loading"></span>');		
	$.post('<?php echo base_url()?>equipos/update_dropdown_equipos',
			{id_grupo: $('#grupo').val()},
			function(data){
					var options = $('#local');
					options.empty();
					$.each(data['equipos'], function(item,value) {
				        options.append($("<option />").val(item).text(value));
				    });
					var options = $('#visita');
					options.empty();
					$.each(data['equipos'], function(item,value) {
				        options.append($("<option />").val(item).text(value));
				    });
					
				    $('.loading').remove();
				},
			"json");
	});	
});
</script>
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo anchor('partidos/admin','Partidos') ?> > 
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>
<?php echo form_open('partidos/guardar'); ?>
 		<input type="hidden" name="id_partido" value="<?php echo set_value('id_partido',empty($partido->id_partido)? '' : $partido->id_partido)?>"/>
		<p><label for="grupo">Campeonato*</label> 
		<?php echo form_dropdown('id_campeonato',$campeonatos,set_value('id_campeonato',isset($partido->id_campeonato) ? $partido->id_campeonato : '')); ?>
		<?php echo form_error('id_campeonato'); ?>
		</p>
        <p><label for="grupo">Grupo</label> 
        	<?php echo form_dropdown('grupo',$grupos,set_value('grupo',isset($partido->id_grupo) ? $partido->id_grupo : 0), "id='grupo'"); ?>
			<?php echo form_error('grupo'); ?>
		</p>
        <p><label for="id_fecha">Fecha</label>
        <?php echo form_dropdown('id_fecha',$fechas,set_value('id_fecha',isset($partido->id_fecha) ? $partido->id_fecha : '')); ?>
        <?php echo form_error('id_fecha'); ?>
        </p>
        <p><label for="fecha">Dia</label> <input name="fecha" type="text" value="<?php echo set_value('fecha', isset($partido->fecha) ? date('d/m/Y H:i',strtotime($partido->fecha)) : date('d/m/Y H:i'));?>">
        <?php echo form_error('fecha'); ?>
        </p>        
        <p><label for="cancha">Cancha</label> 
        <input name="cancha" type="text" id="cancha" value="<?php echo set_value('cancha', isset($partido->cancha) ? $partido->cancha : '')?>">
        <?php echo form_error('cancha'); ?>
        </p>
        <p><label for="libre">Fecha Libre</label>
        <input type="checkbox" name="libre" id="libre" value="1" <?php echo set_checkbox("libre","1",empty($partido->fecha_libre)? FALSE: TRUE); ?>/>
        <?php echo form_error('libre'); ?>
        </p>
        <p><label for="local">Equipo Local</label> 
        	<?php echo form_dropdown('local',$equipos,set_value('local',isset($partido->id_equipo_local) ? $partido->id_equipo_local : ''),"id='local'"); ?>
        	<?php echo form_error('local'); ?>
    	</p>
        <p>
        <label for="visita">Equipo Visita</label> <?php echo form_dropdown('visita',$equipos,set_value('visita',isset($partido->id_equipo_visita) ? $partido->id_equipo_visita : ''), "id='visita'"); ?>
        <?php echo form_error('visita'); ?>
        </p>
       	<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close(); ?>