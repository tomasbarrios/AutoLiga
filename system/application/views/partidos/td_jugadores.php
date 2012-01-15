<?php if (count($incidentes)>0 && $incidentes != FALSE) : ?>
<?php foreach ($incidentes as $incidente) : ?>

<?php echo form_open('incidentes/guardar_incidente');?>

    <?php echo form_dropdown('jugador', $jugadores,set_value('jugador',$incidente->id_jugador) , 'id='.$incidente->id_incidente); ?>
<?php echo form_close();?>
<?php endforeach ?>
<?php endif ?>