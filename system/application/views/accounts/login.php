<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<p class="breadcrum">
<?php echo anchor('','Inicio') ?> > 
<?php echo $title?></p>
<h1 class="titulo"><?php echo $title?></h1>
<?php
    echo form_open('accounts')
?>
<?php if (authentication_errors()): ?>
<p class="error"><?php echo authentication_errors(); ?></p>
<?php endif; ?>
<p><label for="username">Usuario</label><input type="text" name="username" value="" /></p>
<p><label for="password"/>Contrase&ntilde;a</label><input type="password" name="password" value=""/></p>
<p><input id="submit" type="submit" value="Log in"/></p>