<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo $title?></p>
<h1 class="titulo"><?php echo $title?>
</h1>

<?php 
foreach ($fechas as $fecha): 
	foreach ($campeonatos as $campeonato):
		$matchs = array();	
		foreach($partidos as $partido){ 
			if ($fecha->id_fecha == $partido->id_fecha and $campeonato->id_campeonato == $partido->id_campeonato) {
				$matchs[]=$partido;
			}
		}
	

?>
		<?php if (!empty($matchs)) :?>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tbody><tr>
	       <th>Dia</th>       
	       <th>Cancha</th>
	       <th>Grupo</th>            
	       <th colspan="5"><?php echo $campeonato->nombre?> - <?php echo $fecha->nombre?> </th>
	       </tr>               
		<?php foreach($matchs as $partido): ?>
			<?php include('partial_partido_publico.php')?>
		<?php endforeach ?>
		      
	    </tbody></table>
	    <?php endif ?>
	<?php endforeach ?>    
<?php endforeach ?>

       

</body>
</html>