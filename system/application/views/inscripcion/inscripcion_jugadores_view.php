<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo $title ?></p>
<h1 class="titulo"><?php echo $title ?> para <?= $equipo->nombre ?></h1>

<h2>Puedes inscribir el resto del equipo, o hacer esto <a href="/inscripcion/finalizar">más tarde</a>.
20 jugadores máximo.
</h2>

<form action="/inscripcion/jugadores" method="POST">
    <p>
    	<label for="nombre_capitan">Nombre Capitan </label>
    	<input name="nombre_capitan" disabled="true" size="30" type="text" value="<?= $capitan->nombre ?>"/>        
    </p>
<?php for ($i=0; $i<20; $i +=1) :?>
    <p>
    	<label for="nuevo_jugador[<?=$i?>]">Nombre Jugador <?php echo $i+1?></label>
    	<input name="nuevo_jugador[<?=$i?>]" size="30" type="text" value="<?= set_value('nuevo_jugador['.$i.']')?>"/>
        <?= form_error('nuevo_jugador['.$i.']')?>
    </p>
<?php endfor ?>

<p>
    <input id="submit" type="submit" value="Guardar Jugadores"/>
</p>
    
</form>
