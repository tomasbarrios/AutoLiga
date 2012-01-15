<?php $def = $partido->definicion == 'WalkOver'? '(W.O)' : '';?>
<?php $penales_local = !empty($penales[$partido->id_partido][$partido->id_equipo_local])? '('.count($penales[$partido->id_partido][$partido->id_equipo_local]).')': '';?>
<?php $penales_visita = !empty($penales[$partido->id_partido][$partido->id_equipo_visita])? '('.count($penales[$partido->id_partido][$partido->id_equipo_visita]).')': '';?>
<tr>
            <td width="80px"><?php echo ($partido->fecha_libre == 1) ? date('d/m/Y \-\-\:\-\-',strtotime($partido->fecha)) : date('d/m/Y H:i',strtotime($partido->fecha)) ?></td>
            <td width="40px"><?php echo ($partido->fecha_libre == 1)? '-' : $partido->cancha?></td>
            <td width="40px"><?php echo (empty($partido->id_grupo))? '-': $grupos[$partido->id_grupo]?></td>
            <td width="80px"><?php echo anchor('equipos/ver/'.$partido->id_equipo_local,$partido->local)?></td>
            <td width="40px"><?php echo ($partido->jugado)? $partido->goles_local :''?> <?= $def ?> <?= $penales_local ?> </td>
            <td width="10px"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
            <td width="40px"><?= $penales_visita ?> <?php echo ($partido->jugado)? $partido->goles_visita :''?> <?= $def ?> </td>
            <td width="80px"><?php echo ($partido->fecha_libre == 1) ? 'Libre' : anchor('equipos/ver/'.$partido->id_equipo_visita,$partido->visita) ?></td>
</tr>