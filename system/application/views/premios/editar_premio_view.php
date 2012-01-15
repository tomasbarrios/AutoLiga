<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo anchor('premios/admin','Premios') ?> >
<?php echo empty($premio)? '':$premio->nombre.' >' ?>   
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>

<?php echo form_open('premios/guardar')?>
 <input type="hidden" name="id_premio" value="<?php echo set_value('id_premio',empty($premio->id_premio)? '' : $premio->id_premio)?>"/>
 <?php echo form_error('id_premio')?>
<p>
	<label for="grupo">Sponsor</label> 
	<?php echo form_dropdown('id_sponsor',$sponsors,set_value('id_sponsor',isset($premio->id_sponsor) ? $premio->id_sponsor : '')); ?>
	<?php echo form_error('id_sponsor'); ?>
</p>
<p>
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?php echo set_value('nombre',empty($premio->nombre)? '' : $premio->nombre)?>"/>
	<?php echo form_error('nombre'); ?>
</p>
<p>
	<label for="descripcion">Descripcion</label>
	<textarea type="text" cols="40" rows="5" name="descripcion"><?php echo set_value('descripcion',empty($premio->descripcion)? '' : $premio->descripcion)?></textarea>
	<?php echo form_error('descripcion'); ?>
</p>
<p>
	<label for="frecuencia">Frecuencia</label>
	<input type="radio" name="frecuencia" value="semanal" <?php echo set_radio('frecuencia','semanal',isset($premio->frecuencia)? $premio->frecuencia=='semanal' ? TRUE:FALSE : '')?>"/>Semanal
	<input type="radio" name="frecuencia" value="final" <?php echo set_radio('frecuencia','final',isset($premio->frecuencia)? $premio->frecuencia=='final' ? TRUE:FALSE : '')?>"/>Final Liga
	<?php echo form_error('frecuencia'); ?>
</p>
<p>
	<label for="tipo">Destino</label>
	
	<input type="radio" name="tipo" value="jugador" <?php echo set_radio('tipo','jugador',isset($premio->tipo)? $premio->tipo=='jugador' ? TRUE:FALSE : '')?>/>Jugador
	<input type="radio" name="tipo" value="equipo" <?php echo set_radio('tipo','equipo',isset($premio->tipo)? $premio->tipo=='equipo' ? TRUE:FALSE : '')?>/>Equipo
	<?php echo form_error('tipo'); ?>
</p>

<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close()?>