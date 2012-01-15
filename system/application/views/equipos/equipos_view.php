
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Equipos</p>
<h1 class="titulo">Equipos</h1>

    <table>
    	<thead>
    		<th>Nombre</th>
    		<th>Grupo</th>
    	</thead>
    	
    <?php foreach($equipos as $equipo) : ?>        
        <tr>
            <td><?php echo anchor('equipos/ver/'.$equipo->id_equipo,$equipo->nombre); ?></td>
            <td><?php echo (!empty($equipo->grupo)? $grupos[$equipo->grupo] : '-'); ?></td>
        </tr>    
    <?php endforeach;?>
    </table>