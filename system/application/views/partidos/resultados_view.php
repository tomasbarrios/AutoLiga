<style type="text/css">
div.loading {
	display: none;
	position: absolute;
	left: 40%;
	top: 35%;
	width: 150px;
	text-align: center;
	height: 50px;
	line-height: 50px;		
  	background: #333 url(imagenes/spinner.gif) no-repeat center center;
}

.resultado {
	padding: 0 0;
        border-bottom: 1px solid white;
}

.heading {
	padding-top: 20px;
	padding-bottom: 0;
}
</style>
<script type="text/javascript"> 
$(document).ready(function(){
	$('input:checkbox').change(function(){		
		checkbox = $(this);	
		var tr = checkbox.closest('tr');
                var table = $(this).closest('table');
		var id_partido = tr.closest('table').attr('id');		
		if (checkbox.is(':checked')) {
			check = '1';
                        table.find('tr[id^="goles"],tr[id^="amarillas"],tr[id^="rojas"]').fadeIn();

                        table.removeClass('oculto');
		} else {
			check = '0';
			tr.find("td[name='local']").text('');
			tr.find("td[name='visita']").text('');
                        table.find("tr").not("[id^='resumen']").fadeOut();
                        table.addClass('oculto');
		}		
		rellenar(check, id_partido);
							
	});

        $('a.editar').click(function(e){
		e.preventDefault();
		var tr = $(this).closest('tr');
		var table = $(this).closest('table');
		id_partido = table.attr('id');

		if( table.hasClass('oculto') ){
			rellenar(1, id_partido);

			tr.find('input:checkbox').attr('checked','checked');
			table.find('tr[id^="goles"],tr[id^="amarillas"],tr[id^="rojas"]').fadeIn();

                        table.removeClass('oculto');
		} else {
			table.find("tr").not("[id^='resumen']").fadeOut();
                        table.addClass('oculto');
		}

	});


		
	//llena los forms con data
	function rellenar(check, id_partido){
		table = $('#'+id_partido);
                trresumen = $('#resumen_'+id_partido);
		trgoles = $('#goles_'+id_partido);
                trpenales = $('#penales_'+id_partido);
                tramarillas = $('#amarillas_'+id_partido);
                trrojas = $('#rojas_'+id_partido);
		
		$.post('<?php echo base_url();?>partidos/status_jugado', {jugado: check, id_partido: id_partido}, 
				function(data) {

                        //definicion
                        definicion = data['definicion'];
                       
                        table.find('.definicion option').each(function(){ $(this).removeAttr('selected') });
                        table.find('.definicion option[value="'+definicion+'"]').attr('selected','selected');

                        if(definicion == 'WalkOver') {
                            console.log('wo...');
                            var wo = $('#walkover'+id_partido);
                            wo.find('input[value="'+data['ganador']+'"').attr('checked',true);                           
                        }
                        definicion_checks(id_partido, definicion, data['ganador']);
                        
			//goles
			trresumen.find("td[name='local']").text(data['goles_local']);
			trresumen.find("td[name='visita']").text(data['goles_visita']);
			//goles input
			
			trgoles.find("td[name='local']>input").val(data['goles_local']);
			trgoles.find("td[name='visita']>input").val(data['goles_visita']);

                        //penales input
			trpenales.find("td[name='local']>input").val(data['penales_local']);
			trpenales.find("td[name='visita']>input").val(data['penales_visita']);

                        //amarillas input
			tramarillas.find("td[name='local']>input").val(data['amarillas_local']);
			tramarillas.find("td[name='visita']>input").val(data['amarillas_visita']);

                        //rojas input
			trrojas.find("td[name='local']>input").val(data['rojas_local']);
			trrojas.find("td[name='visita']>input").val(data['rojas_visita']);
			
				}
		,'json');
		
	}
	

	
	$('input:text').change(function(e){
		//guardar resumen goles, update de incidentes
		e.preventDefault();
		var select = $(this);
		var tr = $(this).closest('tr');
		var id_partido = tr.closest('table').attr("id");
		var id_equipo = $(this).closest('td').attr("id");
		var goles = $(this).val();
		var incidente = select.attr('name');
		$.post('<?php echo base_url()?>incidentes/guardar_incidentes', {	
							cant_incidentes: select.val(),
							incidente: incidente,
							id_partido: id_partido,
							id_equipo: id_equipo },
							function (data) {
			if(incidente == 'gol'){
				tr.prev().find('#'+id_equipo).html(select.val());
                                
			}			
			tr.next().find('#'+id_equipo).html(data);
			addSelectChange();
                        tr.next().show();
			insertar_asterisco(tr.next());
		});
	});


	function addSelectChange() {
		$("select").bind('change',function () {
			var jugador = $(this);	
			var td = jugador.closest('td');
			$(this).before('<div class="loading"></div>');
			
			$.post(jugador.closest('form').attr('action'), {
							id_incidente: jugador.attr("id"),
							id_jugador: jugador.val() },
							function(data) {
								insertar_asterisco(td.closest('tr'));
								td.find('.loading').removeClass('loading');
							});									
		});
	}
	
	$('.incidente').click(function(e){
		e.preventDefault();
		tr = $(this).closest('tr');	
		table = tr.closest('table');	
		id_partido = table.attr('id');
		incidente = $(this).attr('href');
		id_local = table.find("td[name='local']").attr('id');
		id_visita = table.find("td[name='visita']").attr('id');
		tr = tr.next();
		if (tr.is(':hidden')){
			//load
			$.post('<?php echo base_url()?>incidentes/get_incidentes', 
							{	
							incidente: incidente,
							id_partido: id_partido,
							id_equipo: id_local
							},
							function (data) {
			tr.find('#'+id_local).html(data);
			addSelectChange();
			});
			$.post('<?php echo base_url()?>incidentes/get_incidentes', 
					{	
					incidente: incidente,
					id_partido: id_partido,
					id_equipo: id_visita
					},
					function (data) {
			tr.find('#'+id_visita).html(data);
			addSelectChange();
			});
			tr.fadeIn();
			
		} else {
			tr.fadeOut();
		}
	});
			
	function insertar_asterisco(tr) {		
		insert = tr.prev().find('.incidente');
		insert.find('span').remove();
		tr.find('select').each(function(){
			if($(this).val()=="0") {				
				insert.append('<span>*</span>');
				return false;
			}
		});
	}

        $('.definicion').change(function(){
            table = $(this).closest('table');
            var definicion = $(this).val();
            var id_partido = table.attr('id');
            $.post('<?php echo base_url()?>partidos/update_definicion',
                    {
                        definicion: definicion,
                        id_partido: id_partido
                    },
                    function(data){
                       
                    },
                    "json");

            var definicion = $(this).val();
            $('#'+id_partido+' :input[type="text"]').removeAttr('disabled');
            definicion_checks(id_partido, definicion, null);

        });

        function definicion_checks(id_partido, definicion, ganador_wo){
            /*
            $('#resumen_'+id_partido+' td[name="local"]').text('');
            $('#resumen_'+id_partido+' td[name="visita"]').text('');
            $('#goles_'+id_partido+' td[name="local"]>input').val('0');
            $('#goles_'+id_partido+' td[name="visita"]>input').val('0');
            */
           
            if(definicion == 'Normal'){
                    $('#penales_'+id_partido).hide();
                    $('#walkover'+id_partido).hide();
                    $('#amarillas_'+id_partido).show();
                    $('#rojas_'+id_partido).show();
            } else if (definicion == 'WalkOver'){                    
                    $('#penales_'+id_partido).hide();
                    $('#penales_'+id_partido).next().hide();
                    $('#amarillas_'+id_partido).hide();
                    $('#rojas_'+id_partido).hide();
                    $('#walkover'+id_partido).show();
                    if(ganador_wo == null){
                        $('#'+id_partido+' :input[type="radio"]').removeAttr('checked');                        
                    }
                    $('#'+id_partido+' :input[type="text"]').val('').attr('disabled','disabled');
                    $('#resumen_'+id_partido+' td[name="local"]').text('');
                    $('#resumen_'+id_partido+' td[name="visita"]').text('');
                    
            } else if (definicion == 'Penales'){
                    $('#penales_'+id_partido).show();
                    $('#walkover'+id_partido).hide();
                    $('#amarillas_'+id_partido).show();
                    $('#rojas_'+id_partido).show();
            }
        }

        /* seleccionar quien gano el WO */
        $('input[type="radio"]').change(function(){
            var ganador = $(this).val();
            
            if (ganador == 'local') { perdedor = 'visita' }
            if (ganador == 'visita') { perdedor = 'local' }

            var id_partido = $(this).closest('table').attr('id');
            $(this).next('.loading').show();
            $.post('<?php echo base_url()?>partidos/walkover',
                    {
                        id_partido: id_partido,
                        ganador: ganador,
                        perdedor: perdedor
                    },
                    function(data){

                        $('#resumen_'+id_partido+' td[name="'+ganador+'"]').text(data["golesporwo"]);
                        $('#goles_'+id_partido+' td[name="'+ganador+'"]>input').val(data["golesporwo"]);
                        $('#resumen_'+id_partido+' td[name="'+perdedor+'"]').text("0");
                        $('#goles_'+id_partido+' td[name="'+perdedor+'"]>input').val("0");
                    }
                    ,'json');
        });

});	
</script>
	
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > Resultados</p>
<h1 class="titulo">Resultados</h1>
<?php $definicion = definicion_dd(); ?>
<div id="load" class="loading">Procesando... <img src="<?php echo base_url()?>imagenes/spinner.gif"/></div>
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
		
		<table class="heading">
	      <tbody><tr>
	       <th width="40px">Dia</th> 
	       <th width="50px">Jugado?</th>
	       <th width="30px"></th>           
	       <th colspan="5"><?php echo $campeonato->nombre?> - <?php echo $fecha->nombre?> </th>
	       </tr>
	       </tbody>
	    </table>
		<?php foreach($matchs as $partido): ?>
		<table id="<?php echo $partido->id_partido?>" class="resultado oculto">
			<tr id="resumen_<?php echo $partido->id_partido?>">
				<td width="40px"><?php echo ($partido->fecha_libre == 1) ? date('d/m/Y \-\-\:\-\-',strtotime($partido->fecha)) : date('d/m/Y H:i',strtotime($partido->fecha)) ?></td>
				<td width="50px">
				<?php if(!$partido->fecha_libre) :?>
					<input type="checkbox" name="jugado" value="j"  <?php echo set_checkbox('jugado', 'j', ($partido->jugado==1) ? $partido->jugado == 1 ? TRUE : FALSE : FALSE )?>>
				<?php endif ?>	
				</td>
				<td width="30px">
				<?php if(!$partido->fecha_libre) :?>
				<?php echo anchor('partidos/editar/'.$partido->id_partido,'Editar',"class='editar'")?>
				<?php endif ?>
				</td>		
				
				<td><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>				
				<td name="local" id="<?php echo $partido->id_equipo_local?>"><?php echo ($partido->jugado)? $partido->goles_local :''?></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td name="visita" id="<?php echo $partido->id_equipo_visita?>"><?php echo ($partido->jugado)? $partido->goles_visita :''?></td>
				<td width="25%"><?php echo ($partido->fecha_libre == 1) ? 'Libre' : anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita) ?></td>
			</tr>
			<!-- editar goles -->
			<tr id="goles_<?php echo $partido->id_partido?>" style="display: none">
				<td>
				Definicion</td><td> <?php echo form_dropdown('definicion',$definicion, 'Normal',"class='definicion'")?>				
				</td>
				<td><a href="gol" class="incidente">Goles</a></td>
				<td><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>
				<td id="<?php echo $partido->id_equipo_local?>" name="local"><input type="text"  class="small" name="gol"/></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td id="<?php echo $partido->id_equipo_visita?>" name="visita"><input type="text" class="small" name="gol"/></td>
				<td width=""><?php echo anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita)?></td>				
			</tr>
			<tr class="detalle" style="display: none">
				<td colspan="3">				
				</td>				
				<td colspan="2" id="<?php echo $partido->id_equipo_local?>"></td>
				
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				
				<td colspan="2" id="<?php echo $partido->id_equipo_visita?>"></td>				
			</tr>		

                        <!-- editar penales -->
			<tr id="penales_<?php echo $partido->id_partido?>" style="display: none">
				<td colspan="2"></td>
				<td><a href="penales" class="incidente">Penales</a></td>
				<td><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>
				<td id="<?php echo $partido->id_equipo_local?>" name="local"><input type="text"  class="small" name="penal"/></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td id="<?php echo $partido->id_equipo_visita?>" name="visita"><input type="text" class="small" name="penal"/></td>
				<td width=""><?php echo anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita)?></td>				
			</tr>
			<tr class="detalle" style="display: none">
				<td colspan="3">				
				</td>				
				<td colspan="2" id="<?php echo $partido->id_equipo_local?>"></td>
				
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				
				<td colspan="2" id="<?php echo $partido->id_equipo_visita?>"></td>				
			</tr>

                        <!-- walkover -->
                        <tr id="walkover<?php echo $partido->id_partido?>" style="display:none">
                            <td colspan="3">Seleccione al equipo <strong>ganador</strong></td>
                            <td><?php echo $partido->local ?></td>
                            <td><input type="radio" name="walkover" value="local"></td>
                            <td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
                            <td><input type="radio" name="walkover" value="visita"></td>
                            <td width=""><?php echo $partido->visita?></td>
                        </tr>
                        <!-- /walkover -->
			
						<!-- editar amarillas -->
			<tr id="amarillas_<?php echo $partido->id_partido?>" style="display: none">
				<td colspan="2">				
				</td>
				<td><a href="amarilla" class="incidente">Amarillas</a></td>
				<td><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>
				<td id="<?php echo $partido->id_equipo_local?>" name="local"><input type="text"  class="small" name="amarilla"/></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td id="<?php echo $partido->id_equipo_visita?>" name="visita"><input type="text"  class="small" name="amarilla"/></td>
				<td width=""><?php echo anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita)?></td>
				
			</tr>	
			<tr class="detalle" style="display: none">
				<td colspan="3">				
				</td>				
				<td colspan="2" id="<?php echo $partido->id_equipo_local?>"></td>
				
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				
				<td colspan="2" id="<?php echo $partido->id_equipo_visita?>"></td>				
			</tr>	
						<!-- editar rojas -->
			<tr id="rojas_<?php echo $partido->id_partido?>" style="display: none">
				<td colspan="2">				
				</td>
				<td><a href="roja" class="incidente">Rojas</a></td>
				<td><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>
				<td id="<?php echo $partido->id_equipo_local?>" name="local"><input type="text"  class="small" name="roja"/></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td id="<?php echo $partido->id_equipo_visita?>" name="visita"><input type="text"  class="small" name="roja"/></td>
				<td width=""><?php echo anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita)?></td>
				
			</tr>	
			<tr class="detalle" style="display: none">
				<td colspan="3">				
				</td>				
				<td colspan="2" id="<?php echo $partido->id_equipo_local?>"></td>
				
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				
				<td colspan="2" id="<?php echo $partido->id_equipo_visita?>"></td>				
			</tr>	
		</tbody></table>
		<?php endforeach ?>
		
		      
	    
	    <?php endif ?>
	<?php endforeach ?>    
<?php endforeach ?>
       

</body>
</html>