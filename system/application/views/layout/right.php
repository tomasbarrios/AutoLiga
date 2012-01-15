
<div id="sponsors">

<img src="<?php echo base_url() ?>imagenes/phone-icon.png" width="90" alt="Contacto" />
<h2><?php echo $liga_session['telefono_administrador']?></h2>

<?php foreach($sponsors_banner as $sponsor) :?>

	<a href="<?php echo $sponsor->url?>">
	<img src="<?php echo imagen_sponsor($sponsor->id_sponsor)?>" width="100px" alt="<?php echo $sponsor->nombre?>" />
	</a>
<?php endforeach; ?>
</div>