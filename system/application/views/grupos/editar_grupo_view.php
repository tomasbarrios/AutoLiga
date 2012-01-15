

<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo anchor('grupos/admin','Grupos') ?> >  
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>

<?php echo form_open('grupos/guardar')?>

 <input type="hidden" name="id_grupo" value="<?php echo set_value('id_grupo',empty($grupo->id_grupo)? '' : $grupo->id_grupo)?>"/>
<p>
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?php echo set_value('nombre',empty($grupo->nombre)? '' : $grupo->nombre)?>"/>
	<?php echo form_error('nombre'); ?>
</p>
<p><label for="id_fase">Fase</label>
<?php echo form_dropdown('id_fase',$fases,set_value('id_fase',isset($grupo->id_fase) ? $grupo->id_fase : '')); ?>
<?php echo form_error('id_fase'); ?>
</p>
<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close()?>