<? if($league_settings->inscripciones_abiertas == 1) :?>
<div class="msgbox">
    <h1>Inscripcion abierta!</h1>
    <p><a href="/inscripcion">Inscribe a tu equipo aqui</a></p>
</div>
<? endif ?>﻿
<h1 class="central"><?php echo $liga->texto_home?></h1>



<?php 		
	foreach ($campeonatos as $campeonato):
		$matchs = array();	
    if (!empty($siguiente_fecha)){
      foreach($partidos as $partido){ 
        if ($siguiente_fecha->id_fecha == $partido->id_fecha and $campeonato->id_campeonato == $partido->id_campeonato) {
          $matchs[]=$partido;
        }
      }
    }
?>
		<?php if (!empty($matchs)) :?>
		<h1 class="central">Próxima Fecha</h1>		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tbody><tr>
	       <th>Dia</th>       
	       <th>Cancha</th>
	       <th>Grupo</th>            
	       <th colspan="5"><?php echo $campeonato->nombre?> - <?php echo $siguiente_fecha->nombre?> </th>
	       </tr>
		<?php foreach($matchs as $partido): ?>
			<?php include(APPPATH.'views/partidos/partial_partido_publico.php') ?>
		<?php endforeach ?>
		      
	    </tbody></table>
	    <?php endif ?>
	<?php endforeach ?>    



<?php 	
if(!empty($ultima_fecha)):
	foreach ($campeonatos as $campeonato):
		$matchs = array();	
		foreach($partidos as $partido){ 
			if ($ultima_fecha->id_fecha == $partido->id_fecha and $campeonato->id_campeonato == $partido->id_campeonato) {
				$matchs[]=$partido;
			}
		}
?>
		<?php if (!empty($matchs)) :?>
		<h1 class="central">Últimos Resultados</h1>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tbody><tr>
	       <th>Dia</th>       
	       <th>Cancha</th>
	       <th>Grupo</th>            
	       <th colspan="5"><?php echo $campeonato->nombre?> - <?php echo $ultima_fecha->nombre?> </th>
	       </tr>
		<?php foreach($matchs as $partido): ?>
			<?php include(APPPATH.'views/partidos/partial_partido_publico.php') ?>
		<?php endforeach ?>
		      
	    </tbody></table>
	    <?php endif ?>
	<?php endforeach ?>    
<? endif ?>

<!-- facebook -->
<!-- <?php if (!empty($liga_session['facebook_fan_page'])):?>
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FLigamania-Futbolito-Mujeres%2F115733468493022&amp;send=false&amp;layout=standard&amp;width=670&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=trebuchet+ms&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:670px; height:80px;" allowTransparency="true"></iframe>
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="<?php echo $liga_session['facebook_fan_page']?>" send="false" width="670" show_faces="true" font="trebuchet ms"></fb:like>
<?php endif ?> -->