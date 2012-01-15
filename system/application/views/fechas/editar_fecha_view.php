<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo anchor('fechas/admin','Fechas') ?> >  
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>

<?php echo form_open('fechas/guardar')?>
 <input type="hidden" name="id_fecha" value="<?php echo set_value('id_fecha',empty($fecha->id_fecha)? '' : $fecha->id_fecha)?>"/>
<p>
	<label for="nombre">Nombre</label>
	<input type="text" name="nombre" value="<?php echo set_value('nombre',empty($fecha->nombre)? '' : $fecha->nombre)?>"/>
	<?php echo form_error('nombre'); ?>
</p>
<p>
	<label for="id_campeonato">Campeonato</label>
	
	<?php echo form_dropdown('id_campeonato',$campeonatos,set_value('id_campeonato',isset($fecha->id_campeonato) ? $fecha->id_campeonato : '')); ?>
	<?php echo form_error('id_campeonato'); ?>
</p>
<p>
	<label for="dia">Dia</label>
	<input type="text" name="dia" value="<?php echo set_value('dia',empty($fecha->dia)? date('d/m/Y H:\0\0') : date('d/m/Y H:i',strtotime($fecha->dia)))?>" />
	<?php echo form_error('dia'); ?>
</p>
<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close()?>