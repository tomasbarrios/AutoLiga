
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?></h1>

<form action="/inscripcion" method="POST">
<!--  Nombre Capitan  -->
<p>
    <label for="nombre_equipo">Nombre Equipo</label>
    <input name ="nombre_equipo" type="text" value="<?php echo set_value('nombre_equipo') ?>"/>
    <?php echo form_error('nombre_equipo'); ?>
</p>

<p>Datos del Capitán o jugador que inscribe (Para contactarnos contigo)</p>
<p>
    <label for="nombre_capitan">Nombre y Apellido</label>
    <input name ="nombre_capitan" type="text" value="<?php echo set_value('nombre_capitan') ?>"/>
    <?php echo form_error('nombre_capitan'); ?>
</p>

<p>
    <label for="email_capitan">Email</label>
    <input name ="email_capitan" type="text" value="<?php echo set_value('email_capitan') ?>"/>
    <?php echo form_error('email_capitan'); ?>
</p>

<p>
    <label for="telefono_capitan">Teléfono</label>
    <input name ="telefono_capitan" type="text" value="<?php echo set_value('telefono_capitan') ?>"/>
    <?php echo form_error('telefono_capitan'); ?>
</p>

<p>
    <input id="submit" type="submit" value="Inscribir"/>
</p>
    
</form>
