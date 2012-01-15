<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum">
<?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> >
<?php echo $title?></p>
<h1 class="titulo"><?php echo $title?></h1>
<?php
echo form_open('accounts/create');
?>

<p><label for="username">Usuario</label>
    <input type="text" name="username" value="<?php echo set_value('username')?>" />
</p>
<p><label for="password"/>Contraseña</label><input type="password" name="password" value="<?php echo set_value('password')?>"/></p>
<p><label for="passwordconf"/>Repetir Contraseña</label><input type="password" name="passwordconf" value="<?php echo set_value('passwordconf')?>"/></p>
<p><input id="submit" type="submit" value="Guardar"/></p>

<?php
echo form_close();
?>