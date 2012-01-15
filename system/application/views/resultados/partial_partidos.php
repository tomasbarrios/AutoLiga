<?php foreach($partidos as $partido): ?>
        <!-- inicio box partido -->
	<div class="partido">
		<div id="partido_1" class="header header-partido">
			<h4>
				<span><?php echo $partido->id_equipo_local ?></span>
				<span class="result"><?php echo $partido->goles_local ?></span>
				<span>vs</span>
				<span class="result"><?php echo $partido->goles_visita ?></span>
				<span><?php echo $partido->id_equipo_visita ?></span>
			</h4>
			<div class="right-header">
				<a href="#" class="view_match_details">mas</a>
				<span class="definicion">Definicion
					<?php echo form_dropdown('definicion',definicion_dd(), 'Normal')?>
				</span>
                                <span class="jugado">Jugado:<input type="checkbox" name="jugado" <?echo set_checkbox('jugado',1,1)?>/></span>
			</div>
		</div>
	</div>
	<!-- fin box partido -->
<?php endforeach ?>