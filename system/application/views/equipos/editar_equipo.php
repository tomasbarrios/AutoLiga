<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(document).ready(function(){
		$('a#del').click(function(e){
			e.preventDefault();
			input = $(this).prev('input');
			p = $(this).closest('p')
			$.post('<?php echo base_url()?>equipos/eliminar_jugador', { id_jugador: input.attr('id') },
				function (data) {
					if (data == "1") {
						p.fadeOut("slow", function () {
							p.remove();
						});
						$('#submit').closest('p').before('<p><label for="nombre">Nombre Jugador</label><input name="nuevo_jugador[]" size="30" type="text" value=""/></p>');
					} else {
						alert("El jugador registra goles/amarillas/rojas, cambie estos datos antes de eliminarlo.")
					}
			});
		});

		$('#group > a').click(function(e){
			e.preventDefault();
			$('#group').fadeOut("slow");
			$('#add_group').fadeIn("slow");			
		});
		$('#add_group :button').click(function(){
			var grupo = $('#add_group').find("input[name='nombre_grupo']").val(); 
			$.post('<?php echo base_url()?>grupos/crear',
					{nombre: grupo},
					function(data){
						$('#group select :selected').removeAttr('selected');

						$("select[name='grupo']").append(new Option(grupo,data,true,true));							
						$('#add_group').fadeOut("slow");
						$('#group').fadeIn("slow");														
					});	
			
			
		});
	});
</script>
<?php $title = (!empty($equipo)) ? $equipo->nombre : 'Nuevo'; ?>
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo anchor('equipos/admin','Equipos') ?> > 
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>

<div class="foto">
<?php 
if(!empty($equipo)) : 

	$imagen = 'imagenes/equipos/'.$equipo->id_equipo.'_width_500.jpg';
	if(file_exists($imagen)) :?>
		<img src="<?php echo base_url().$imagen;?>"?>
	<?php else : ?>
		Aun no existe una foto para este equipo.
	<?php endif ?>
<?php else : ?>
		Aun no existe una foto para este equipo.
	<?php endif ?>	

                                
</div>
<?php
echo form_open_multipart('equipos/guardar');
if (!empty($equipo)){
echo form_hidden('id_equipo',$equipo->id_equipo);
}
?>
<p>
    <label for="foto">Foto</label>
    <input type="file" name="foto">
</p>
<p>
    <label for="nombre">Nombre Equipo</label>
    <input name ="nombre" type="text" value="<?php echo set_value('nombre',!empty($equipo->nombre)? $equipo->nombre : '') ?>"/>
	<?= form_error('nombre'); ?>
</p>
<p>
    <label for="nombre">Grupo</label>
    <div id="group">
    	<?php echo form_dropdown('grupo',$grupos,isset($equipo->grupo) ? $equipo->grupo : 0 ,"class='medium'"); ?>
    	<a href="">Agregar</a>
    </div >
    <div style="display:none" id="add_group"><input type="text"  name="nombre_grupo"><input type="button" value="Agregar"></div>
</p>
<div class="box">

	<p>
		<label>Capitan</label>
		<div style="text-align: left;"><?= isset($capitan->nombre)? $capitan->nombre : '-'?></div>
	</p>
	<p>
		<label>Email</label>
		<div style="text-align: left;"><?= isset($capitan->email)? $capitan->email : '-'?></div>
	</p>
	<p>
		<label>Telefono</label>
		<div style="text-align: left;"><?= isset($capitan->telefono)? $capitan->telefono : '-'?></div>
	</p>
</div>
<?php if (!empty($jugadores)) :?>
<?php foreach ($jugadores as $key => $jugador) :?>
    <p>
        <label for="nombre">Nombre Jugador <?php echo $key+1?></label>
        <input name="jugador[<?php echo $jugador->id_jugador ?>]" id="<?php echo $jugador->id_jugador ?>" size="30" type="text" value="<?php echo set_value('jugador', isset($jugador->nombre) ? $jugador->nombre : '') ?>"/>
		
        <a href="" id="del"><img src="<?php echo base_url();?>imagenes/cross-button.png" alt="Eliminar"/></a>
    </p>
<?php endforeach ?>
<?php else: $jugadores = array(); ?>
<?php endif ?>
<?php for ($i=count($jugadores); $i<20; $i +=1) :?>
    <p>
    	<label for="nombre">Nombre Jugador <?php echo $i+1?></label>
    	<input name="nuevo_jugador[]" size="30" type="text" value=""/>
    </p>
<?php endfor ?>
<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php form_close(); ?>