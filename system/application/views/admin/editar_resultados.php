<style type="text/css">

input {
	width: 20px;
}

.tr-incidentes {
	display:none;
}

.amarillas {
	color: yellow;
}

.rojas {
	color: red;
}


DIV.loading {
	width: 20px;
	height: 20px;
  background: url(<?php echo base_url(); ?>imagenes/spinner.gif) no-repeat center center;
}

.tips {
	padding: 10px 30px;
	background: #7d7;
	margin: 10px 0;
	color: green;
}

.tips li {
	padding-bottom: 5px;
	list-style-type: disc;
}
</style>
<script type="text/javascript"> 
$(document).ready(function(){
	addSelectChange();
	$('input:checkbox').change(function(){		
		var tr = $(this).closest('tr');		
		if ($(this).is(':checked')) {
			check = '1';
			tr.find('input').not(':checkbox').attr('disabled','');
			tr.next().find('input').attr('disabled','');
			tr.next().next().find('input').attr('disabled','');
			tr.next().next().next().find('input').attr('disabled','');
			tr.next().next().next().next().find('input').attr('disabled','');
			tr.next().next().next().next().next().find('input').attr('disabled','');
		} else {
			check = '0';
			tr.find('input').not(':checkbox').attr('disabled','disabled');
			tr.next().find('input').attr('disabled','disabled');
			tr.next().next().find('input').attr('disabled','disabled');
			tr.next().next().next().find('input').attr('disabled','disabled');
			tr.next().next().next().next().find('input').attr('disabled','disabled');
			tr.next().next().next().next().next().find('input').attr('disabled','disabled');
		}		
		
		var id_partido = tr.attr('id');
		$.post('<?php echo base_url();?>partidos/status_jugado', {jugado: check, id_partido: id_partido}, function(data) {
			if (check == '1'){
				tr.find("td[name='local']").find('input').val(data['goles_local']);
				tr.find("td[name='visita']").find('input').val(data['goles_visita']);
			}
		},'json');		
	});	
	
	$('input:text').change(function(e){
		//guardar resumen goles, update de incidentes
		e.preventDefault();
		var select = $(this);
		var tr = $(this).closest('tr');
		var id_partido = tr.attr("id");
		var id_equipo = $(this).closest('td').attr("id");
		var goles = $(this).val();
		var incidente = select.attr('name');
		$.post(select.closest('form').attr('action'), {	cant_incidentes: select.val(),
							incidente: incidente,
							id_partido: id_partido,
							id_equipo: id_equipo },
							function (data) {
			tr.next().find("[name="+id_equipo+"]").html(data);
			addSelectChange();
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
	$('.incidente').click(function(){
		$(this).closest('tr').next().toggle();
	});
	
	//cambiar el color del link si esta incompleto el detalle
	$("tr[name='goles'],tr[name='amarillas'],tr[name='rojas']").each(function(){
		insertar_asterisco($(this));
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
	
});

</script> 
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('admin','Administracion') ?> > Resultados</p>
<h1 class="titulo">Resultados</h1>
<div class="tips"><ul><li>* = datos incompletos</li>
	<li>Para ver o editar el detalle hacer click en Goles/Amarillas/Rojas</li></ul>
	
</div>
<?php foreach ($fechas as $fecha): 	
	foreach ($grupos as $grupo):
?>



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
	       <th></th>      
	       <th>Cancha</th>
	       <th>Grupo</th>  
	       <th>Jugado?</th>          
	       <th colspan="5"><?php echo $campeonato->nombre?> - <?php echo $fecha->nombre?> </th>
	       </tr>
		<?php foreach($matchs as $partido): ?>
			<tr>
				<td width="20%"><?php echo ($partido->fecha_libre == 1) ? date('d/m/Y \-\-\:\-\-',strtotime($partido->fecha)) : date('d/m/Y H:i',strtotime($partido->fecha)) ?></td>
				<td><?php echo anchor('partidos/editar/'.$partido->id_partido,'Editar')?></td>			
				<td width="5%"><?php echo ($partido->fecha_libre == 1)? '-' : $partido->cancha?></td>
				<td><?php echo ($partido->id_grupo==null)? '-': $partido->id_grupo?></td>
				<td><input type="checkbox" name="jugado" value="j"  <?php echo set_checkbox('jugado', 'j', ($row->jugado==1) ? $row->jugado == 1 ? TRUE : FALSE : FALSE )?>></td>
				<td width="25%"><?php echo anchor('equipos/editar/'.$partido->id_equipo_local,$partido->local)?></td>
				<td><?php echo ($partido->jugado)? $partido->goles_local :''?></td>
				<td width="5%"><?php echo($partido->fecha_libre == 1) ? '' : 'vs'?></td>
				<td><?php echo ($partido->jugado)? $partido->goles_visita :''?></td>
				<td width="25%"><?php echo ($partido->fecha_libre == 1) ? 'Libre' : anchor('equipos/editar/'.$partido->id_equipo_visita,$partido->visita) ?></td>
			</tr>			
		<?php endforeach ?>
		      
	    </tbody></table>
	    <?php endif ?>
	<?php endforeach ?>    
<?php endforeach ?>

