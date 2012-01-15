<script type="text/javascript"> 
<!-- 
function línea() { 
var texto = document.getElementById("equipo").value; 
var def_texto= texto.replace(/\n/g, "<br />"); 
document.getElementById("equipo").value = def_texto; 
} 
--> 
</script>
<?php

echo form_open('equipos/guardar');

?>
<p>
    <textarea name="equipo" id="equipo" rows="30" cols="50"></textarea>
</p>


<p><input type="submit" name="submit" value="Registrar Jugadores" onclick='linea();'/></p>
<?php form_close(); ?>