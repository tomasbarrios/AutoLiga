<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#sponsors").tableDnD({
		onDrop: function(table, row){
		var filas = new Array();
		$('#sponsors').find('tr').each(function(i){ filas.push($(this).attr('id')) });
		$.post('<?php echo base_url() ?>sponsors/orden',{'filas[]': filas}, function(data){});
		}
	});
	
});
</script>

<p class="breadcrum"><?php echo anchor('','Inicio') ?> > 
<?php echo anchor('admin','Administracion') ?> > <?php echo $title?></p>
<h1 class="titulo">
	<?php echo $title ?>
	<span class="opciones"><?php echo anchor('sponsors/nuevo','[Nuevo]');?></span>
</h1>

<?php if(!empty($sponsors)) :?>
<table id="sponsors">
	<tbody>
		<tr class="nodrag">
			<th>Nombre</th>
			<th>Imagen</th>
			<th>Pagina Web</th>
			<th></th>            
	    </tr>
	    
<?php foreach ($sponsors as $sponsor) :?>
		<tr id="<?php echo $sponsor->id_sponsor ?>">
			<td><?php echo anchor('sponsors/editar/'.$sponsor->id_sponsor, $sponsor->nombre)?></td>
			<?php $img_properties = array('src'=>'imagenes/sponsors/'.$sponsor->id_sponsor.'_thumb.jpg','class'=>'preview'); ?>
			<td><?php echo img($img_properties); ?></td>
			<td><?php echo $sponsor->url;?></td>
			<td><?php echo anchor('sponsors/eliminar/'.$sponsor->id_sponsor, 'Eliminar');?></td>
		</tr>	       
<?php endforeach ?>
	</tbody>
</table>
<?php else :?>
<p>No hay ningun sponsor registrado</p>
<?php endif ?>

