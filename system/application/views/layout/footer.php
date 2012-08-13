 <ul id="banner-sponsors">
  <?php foreach($sponsors_banner as $sponsor) :?>
    <li>
      <a href="<?php echo $sponsor->url?>">
        <img src="<?php echo imagen_sponsor($sponsor->id_sponsor)?>" width="100px" alt="<?php echo $sponsor->nombre?>" />
      </a>
    </li>
  <?php endforeach; ?>
  </ul>
<!--Sitio web desarrollado por <a href="mailto:tomasbarrios@gmail.com">Silla de Playa</a> Software Factory - 2010.--> 