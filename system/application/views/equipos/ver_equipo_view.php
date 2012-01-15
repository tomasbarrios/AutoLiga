<script language="javascript" type="text/javascript" src="/scripts/jqplot/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/jqplot/jquery.jqplot.css" />
<script type="text/javascript" src="../src/plugins/jqplot.barRenderer.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var s1 = [200, 600, 700, 1000];
    var s2 = [460, -210, 690, 820];
    var s3 = [-260, -440, 320, 200];
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
    var ticks = ['May', 'June', 'July', 'August'];

    var plot1 = $.jqplot('goles_equipo', [s1, s2, s3], {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true}
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label:'Hotel'},
            {label:'Event Regristration'},
            {label:'Airfare'}
        ],
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of "outside" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: {
            show: true,
            placement: 'outsideGrid'
        }
        
    });
});
</script>
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('equipos','Equipos') ?> > <?php echo $equipo->nombre ?></p>
<h1 class="titulo"><?php echo $equipo->nombre ?></h1>
<div class="foto">
<?php $imagen = 'imagenes/equipos/'.$equipo->id_equipo.'_width_500.jpg';
                                
if(file_exists($imagen)) :?>

		<img src="<?php echo base_url().$imagen;?>"?>
	<?php else : ?>
		Aun no existe una foto para este equipo.
	<?php endif ?>
</div>

<div class="stats">
    <div id="goles_equipo" style="height:300px; "></div>
</div>

<table>
	<tbody>
		<tr>
			<th>Jugadores</th>      
			<th>Goles</th>      
			<th>TA</th>      
			<th>TR</th>      
        </tr>
                <?php foreach ($jugadores as $jugador): ?>
		<tr>
			<td><?php echo $jugador->nombre ?></td>
			<td><?php echo isset($goles[$jugador->id_jugador]) ? $goles[$jugador->id_jugador]:0 ?></td>
			<td><?php echo isset($amarillas[$jugador->id_jugador]) ? $amarillas[$jugador->id_jugador] : 0?></td>
			<td><?php echo isset($rojas[$jugador->id_jugador])? $rojas[$jugador->id_jugador] : 0 ?></td>
		</tr>
                <?php endforeach ?>
	</tbody>
</table>