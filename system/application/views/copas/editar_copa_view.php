<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo anchor('copas/admin','Fases') ?> >  
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>

<?php echo form_open('copas/guardar')?>

 <input type="hidden" name="id_campeonato" value="<?php echo set_value('id_campeonato',empty($copa->id_campeonato)? '' : $copa->id_campeonato)?>"/>
<p>
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?php echo set_value('nombre',empty($copa->nombre)? '' : $copa->nombre)?>"/>
	<?php echo form_error('nombre'); ?>
</p>
<p>
	<label for="formato">Formato</label>
	<input type="radio" name="formato" value="regular" <?php echo set_radio('formato', 'regular', !empty($copa)? ($copa->formato == 'regular')? TRUE : FALSE : FALSE); ?>>Regular</input>
	<input type="radio" name="formato" value="playoff" <?php echo set_radio('formato', 'playoff', !empty($copa)? ($copa->formato == 'playoff')? TRUE : FALSE : FALSE); ?>>Playoff</input>
	<?php echo form_error('formato'); ?>
</p>
<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close()?>