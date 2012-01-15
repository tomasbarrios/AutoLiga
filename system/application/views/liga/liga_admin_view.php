<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />

<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >  
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>
<?php echo form_open_multipart('ligas/guardar'); ?>
		<p><label for="nombre">Nombre</label> 
		<input name="nombre" class="medium" type="text" value="<?php echo set_value('nombre', isset($liga->nombre) ? $liga->nombre : '')?>">
		<?php echo form_error('nombre');?>
		</p>
		<p><label for="url">URL</label> 
		<input name="url" class="large" type="text" value="<?php echo set_value('url', isset($liga->url) ? $liga->url : '')?>">
		</p>
		<p><label for="direccion">Dirección</label> 
		<input name="direccion" class="large" type="text" value="<?php echo set_value('direccion', isset($liga->direccion) ? $liga->direccion : '')?>">
		</p>
		<p><label for="comuna">Comuna</label> 
		<input name="comuna" class="large" type="text" value="<?php echo set_value('comuna', isset($liga->comuna) ? $liga->comuna : '')?>">
		</p>
		<p><label for="nombre_administrador">Nombre Encargado</label> 
		<input name="nombre_administrador" class="large" type="text" value="<?php echo set_value('nombre_administrador', isset($liga->nombre_administrador) ? $liga->nombre_administrador : '')?>">
		</p>
		<p><label for="email_administrador">Email Encargado</label> 
		<input name="email_administrador" class="large" type="text" value="<?php echo set_value('email_administrador', isset($liga->email_administrador) ? $liga->email_administrador : '')?>">
		</p>
		<p><label for="telefono_administrador">Teléfono Contacto</label> 
		<input name="telefono_administrador" class="medium" type="text" value="<?php echo set_value('telefono_administrador', isset($liga->telefono_administrador) ? $liga->telefono_administrador : '')?>">
		</p>
		<hr>
		<p><label for="facebook_fan_page">Facebook Fan Page</label> 
		<input name="facebook_fan_page" class="extralarge" type="text" value="<?php echo set_value('facebook_fan_page', isset($liga->facebook_fan_page) ? $liga->facebook_fan_page : '')?>">
		<?php echo form_error('facebook_fan_page');?>
		</p>
                <p>
                    <label for="bases">Actualizar Bases</label>
                    <input name="bases" class="large" type="file">
                    <?php echo form_error('bases');?>
		</p>
		<p><label for="banner">Banner</label> 
		<input name="banner" class="large" type="file">
		<?php echo form_error('facebook_fan_page');?>
		</p>
       	<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php echo form_close(); ?>