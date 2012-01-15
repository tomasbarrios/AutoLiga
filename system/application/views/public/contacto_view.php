<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Contacto</p>
<h1 class="titulo">Contacto</h1>
<?php echo validation_errors(); 
echo form_open('mail/contacto',array('class'=>'contacto'));?>
<p><label for="nombre">Nombre</label><input type="text" name="nombre" value="<?php echo set_value('nombre'); ?>"  /></p> 
<p><label for="email">Email</label><input type="text" name="email" value="<?php echo set_value('email'); ?>"  /></p> 
<p><label for="telefono">Teléfono</label><input type="text" name="telefono" value="<?php echo set_value('telefono'); ?>"  /></p> 
<p><label for="mensaje">Mensaje</label><textarea name="mensaje" cols="40" rows="12"><?php echo set_value('mensaje'); ?></textarea></p> 

<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Enviar'));?></p>
