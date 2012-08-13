<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
xml:lang="es"
lang="es"
dir="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php $liga = $this->session->userdata('liga')?>
<title><?php echo $liga['nombre']?></title>
<link href="<?php echo base_url(); ?>css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/<?php echo clean_url($this->session->userdata('url'))?>.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>

<?php if(strpos(clean_url($this->session->userdata('url')),'ligamania.cl')!==FALSE):?>
<script type="text/javascript" src="<?php echo base_url()?>scripts/swfobject/swfobject.js"></script>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script src="http://bxslider.com/sites/default/files/jquery.bxSlider.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
  $('#banner-sponsors').bxSlider({
    ticker: true,
    tickerSpeed: 1500,
    displaySlideQty: 8,
    moveSlideQty:1
  });
});
</script>

<script type="text/javascript">
var flashvars = {};
var attributes = {};
var params = {
  bgcolor: "#000000",

};
swfobject.embedSWF("<?php echo base_url()?>imagenes/ligamania2.swf", "myFlash", "680", "150", "9.0.0", false,false, params);
</script>
<?php endif ?>
<?= $league_settings->google_analytics_script ?>
</head>

<body>

  <div id="container">

    <div id="header">
      <div id="contacto">
        <h4><?php echo $liga_session['telefono_administrador']?></h4>
        <img src="<?php echo base_url() ?>imagenes/phone-icon.png" width="90" alt="Contacto" />
      </div>
      
      <?php include('layout/header.php'); ?>
    </div>
    <div id="menu">
      <?php include('layout/menu.php'); ?>
    </div>
    <div id="wrapper">
      <div id="content">
        <?php include('layout/mensajes.php') ?>
        <?php echo $content_for_layout?>
      </div>

     

    
      </div>
       <div id="footer"><?php include('layout/footer.php'); ?></div>
    </div>





</body>




</body>
</html>

