<?php if (!empty($tarjetas)) :?>
<table>
    <thead>
        <tr>
            <th>Jugador</th>
            <th>Equipo</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tarjetas as $tarjeta): ?>
        <?php if(!empty($tarjeta->jugador)): ?>
        <tr>
            <td><?php echo ucwords($tarjeta->jugador) ?></td>
            <td><?php echo anchor('equipos/ver/'.$tarjeta->id_equipo,ucfirst(strtolower($tarjeta->equipo)))?></td>
            <td><?= ucwords($tarjeta->fecha) ?></td>
        </tr>
        <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>
<?php else :?>
No hay tarjetas registradas
<?php endif ?>