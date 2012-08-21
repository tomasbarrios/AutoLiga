<ul class="nav nav-list" id="menu">
    <li class="nav-header">
        General
    </li>
    <? if($this->erkana_auth->is_logged_in()) :?>
    <li><?php echo anchor('admin','Administración');?></li>
    <? endif ?>
    <li><?php echo anchor('','Inicio');?></li>
    <li><?php echo anchor('posiciones','Posiciones');?></li>
    <li><?php echo anchor('partidos','Partidos');?></li>
    <li><?php echo anchor('estadisticas/goleadores','Goleadores');?></li>
    <li><?php echo anchor('tarjetas/amarillas','Amarillas');?></li>
    <li><?php echo anchor('tarjetas/rojas','Rojas');?></li>
    <li><?php echo anchor('suspensiones','Suspendidos');?></li>    
    <li><?php echo anchor('equipos','Equipos');?></li>
    

    <?php if (!empty($menu_premios)) :?>
    <li class="nav-header">
        Premios
    </li>
    <?php foreach ($menu_premios as $premio):?> 
        <li><?php echo anchor('premios/ver/'.$premio->id_premio,$premio->nombre);?></li>
    <?php endforeach; ?>
    <?php endif ?> 

    <li class="nav-header">
        Info
    </li>   
    <li><a href="<?php echo base_url()?>docs/<?php echo $this->session->userdata('url')?>-bases_.pdf">Bases</a></li>
    <!--<li><?php echo anchor('premios','Premios');?></li>-->
    <li><?php echo anchor('ligas/ubicacion','Ubicacion');?></li>
    <li><?php echo anchor('home/contacto','Contacto');?></li>  
</ul>

<?php if (!empty($liga_session['facebook_fan_page'])):?>
<!--

  <div id="fb-root"></div>

<script src="http://connect.facebook.net/es_CL/all.js#xfbml=1"></script>
<fb:like-box href="<?php echo $liga_session['facebook_fan_page']?>" width="182" connections="10" stream="false" header="false"></fb:like-box>
-->
<?php endif ?>

