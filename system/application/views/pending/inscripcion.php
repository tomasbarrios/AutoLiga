<?php

echo form_open('equipos/registrar');

?>
<p>Nombre Equipo: <input type="text" maxlength="45" name="nombre_equipo"/></p>
<?php
// mostrar 15 jugadores
    
    echo '<p>'.form_label('Nombre Capitan: ', 'jugador[1]');
    echo form_input('jugador[1]').'</p>';
    
    echo '<p>'.form_label('Telefono Fijo: ', 'telefono_fijo');
    echo form_input('telefono_fijo').'</p>';
    
    echo '<p>'.form_label('Telefono Celular: ', 'telefono_celular');
    echo form_input('telefono_celular').'</p>';
    
    echo '<p>'.form_label('Email: ', 'email');
    echo form_input('email').'</p>';
?>
<p>Plantel (exluyendo al capitan)</p>
<?php

for ( $i = 2 ; $i <= 15 ; $i += 1 ):
    echo '<p>'.form_label('Nombre Jugador: ', 'jugador['.$i.']');
    echo form_input('jugador['.$i.']').'</p>';    
endfor

?>
<p><input type="submit" name="submit" value="Registrar Jugadores" /></p>