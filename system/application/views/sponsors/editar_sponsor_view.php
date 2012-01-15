<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > 
<?php echo anchor('sponsors/admin','Sponsors') ?> >
<?php echo $title?></p>
<h1 class="titulo">
	<?php echo $title ?>
</h1>
<?php echo form_open_multipart('sponsors/guardar',array('class'=>'contacto')); ?>
<?php 
if (!empty($sponsor)) :
echo form_hidden('id_sponsor',$sponsor->id_sponsor);
$img_properties = array('src'=>'imagenes/sponsors/'.$sponsor->id_sponsor.'_300.jpg','class'=>'thumb150'); ?>
<p><?php echo img($img_properties); ?></p>
<?php endif ?>
<p><label for="nombre">Nombre</label>
<input type="text" name="nombre" value="<?php echo (!empty($sponsor))? ($sponsor->nombre): ''; ?>"  /></p> 
<p><label for="imagen">Imagen</label>
<input type="file" name="imagen" value="<?php echo set_value('imagen'); ?>"  /></p> 
<p><label for="url">Pagina Web</label>
<input type="text" class="extralarge" name="url" value="<?php echo (!empty($sponsor))? ($sponsor->url): 'http://'; ?>"  /></p> 
 
<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php form_close() ?>


