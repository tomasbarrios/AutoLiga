

<?php function revisar_partido($grupo, $fecha, $num_partido, $local,$visita) {
    if ($local->nombre == 'libre') {
        echo 'Libre: '.$visita->nombre;
    } elseif ( $visita->nombre == 'libre' ) {
        echo 'Libre: '.$local->nombre;
    } else {
        echo $local->nombre ?> VS <?php echo $visita->nombre;    
    }
    echo form_hidden('fecha['.$grupo.']['.$fecha.']['.$num_partido.'][local]', $local->id_equipo);
    echo form_hidden('fecha['.$grupo.']['.$fecha.']['.$num_partido.'][visita]', $visita->id_equipo);
    
    
}
?>

<ol>
    
    <?php echo form_open('fixture/guardar'); ?>    
    <?php foreach ($grupos as $key => $grupo): ?>
    <h1><?php echo 'Grupo '.($key+1) ?></h1>
	<?php foreach($grupo as $key2 => $fechas): ?>
        <p><?php echo 'Fecha '.($key2+1) ?> <ol>
            <?php foreach ($fechas as $key3 => $partido): ?>
            <li><?php revisar_partido ($key+1, $key2, $key3, $partido[0], $partido[1]); ?>
            
            </li>
            <?php endforeach ?>
        </ol></p>
        <?php endforeach ?>
    <?php endforeach ?>
    
    <p><input type="submit" name="submit" value="Aprobar y Guardar Fixture" /></p>    
        
</ol>

</body>
</html>