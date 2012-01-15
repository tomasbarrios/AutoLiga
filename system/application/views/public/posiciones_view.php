<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Posiciones</p>
<h1 class="titulo">Posiciones</h1>

<?php 	
	foreach ($grupos as $grupo) :
?>
<?php $equipos_grupo = array();?>
       <?php foreach ($equipos as $equipo): ?>
			<?php if ($equipo->grupo == $grupo->id_grupo):?>
				<?php $equipos_grupo[]=$equipo?>
			<?php endif; ?>	
		<?php endforeach;?>       
       
<?php if(!empty($equipos_grupo)):?>  
<h2><?php echo $grupo->nombre ?></h2>
<table>
      <tbody><tr>
        <th>#</th>
        <th>Equipo</th>
	<th>Puntos</th>
	<th>DG</th>
        <th>PJ</th>
        <th>PG</th>
        <th>PE</th>
        <th>PP</th>
        <th>GF</th>
        <th>GC</th>
        
        
       </tr>
       <?php $key = 0;?>
       <?php foreach ($equipos_grupo as $equipo): ?>			
		<tr> <?php $key++; ?>
            <td><?php echo $key ?></td>
		    <td><?php echo anchor('equipos/ver/'.$equipo->id_equipo,$equipo->nombre) ?></td>
		    <td><?php echo $equipo->puntos ?></td>
		    <td><?php echo $equipo->dg ?></td>
		    <td><?php echo ($equipo->pg+$equipo->pe+$equipo->pp) ?></td>
		    <td><?php echo $equipo->pg ?></td>
		    <td><?php echo $equipo->pe ?></td>
		    <td><?php echo $equipo->pp ?></td>
		    <td><?php echo $equipo->gf ?></td>
		    <td><?php echo $equipo->gc ?></td>
		    
                
		</tr>		
		<?php endforeach ?>
    </tbody></table>
<?php endif ?>

<?php endforeach ?>
<?php if(!empty($equipos)) :?>
       <?php foreach ($equipos as $equipo): ?>
		<?php if ($equipo->grupo == 0):?>
		<?php $regular[]=$equipo?>
		<?php endif; ?>	
		<?php endforeach;?>
<?php endif?>       
       
<?php if(!empty($regular)):?>       
<h2>Tabla Fase Regular</h2>
<table>
      <tbody><tr>
        <th>#</th>
        <th>Equipo</th>
	<th>Puntos</th>
	<th>DG</th>
        <th>PJ</th>
        <th>PG</th>
        <th>PE</th>
        <th>PP</th>
        <th>GF</th>
        <th>GC</th>
        
        
       </tr>
       <?php $key = 0;?>
       <?php foreach ($regular as $equipo): ?>		
		<tr> <?php $key++; ?>
            <td><?php echo $key ?></td>
		    <td><?php echo anchor('equipos/ver/'.$equipo->id_equipo,$equipo->nombre) ?></td>
		    <td><?php echo $equipo->puntos ?></td>
		    <td><?php echo $equipo->dg ?></td>
		    <td><?php echo ($equipo->pg+$equipo->pe+$equipo->pp) ?></td>
		    <td><?php echo $equipo->pg ?></td>
		    <td><?php echo $equipo->pe ?></td>
		    <td><?php echo $equipo->pp ?></td>
		    <td><?php echo $equipo->gf ?></td>
		    <td><?php echo $equipo->gc ?></td>
		</tr>
		<?php endforeach ?>
    </tbody></table>
<?php endif;?>
</body>
</html>