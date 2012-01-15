<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

  <script>
  $(document).ready(function() {
    $(".datepicker").datepicker({
       dateFormat : "dd/mm/yy"
  })
  });
  </script>

<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('admin','Administracion') ?> > <?php echo $title ?></p>
<h1 class="titulo">
	<?php echo $title ?>
</h1>
<p class="box">Cerciorate que haz completado los siguientes pasos</p>
<ol>
	<li>Todos los equipos estan registrados y activados</li>
	<li>Cada equipo pertenece a un grupo (para fases de tipo regular)</li>
</ol>
<p>A continuacion se muestra una lista con los equipos asociados a la fase y su estado</p>
<? if (!empty($equipos)): ?>
<table>
	<tbody>
	<tr>
		<th>Nombre</th>
		<th>Estado</th>
		<th>Grupo</th>
	</tr>
	<? foreach ($equipos as $equipo):?>
	<tr>
		<td><?= $equipo->nombre?></td>
		<td><?= $equipo->activo? 'Activo' : 'Inactivo'?></td>
		<td><?= isset($equipo->grupo) ? $grupos[$equipo->grupo] : 'Edita y define el grupo de este equipo'?></td>
	</tr>
	<? endforeach ?>
	</tbody>
	</table>
	<form action="/copas/confirmar_generar_fixture" method="POST">
		<input type="hidden" name="id_fase" value="<?= $id_fase ?>">
	<p>
		<label for="fecha">Primera Fecha</label> 
		<input name="fecha" type="text" value=""  class="datepicker"/>
       	<?php echo form_error('fecha'); ?>
    </p>
	<p>
		<label for="hora">Hora Inicio</label> 
		<input name="hora" type="text" size="5"/><span> (HH:MM)</span>
       	<?php echo form_error('hora'); ?>
    </p>
	<p>
		<label for="cantidad_canchas">Canchas Disponibles</label> 
		<input name="cantidad_canchas" size="3" type="text" value=""/>
       	<?php echo form_error('cantidad_canchas'); ?>
    </p>
	<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Generar Fixture'));?></p>
	</form>
	
<? else: ?>
No hay equipos registrados aun.
<? endif ?>

	