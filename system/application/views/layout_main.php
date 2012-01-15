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

<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.4.2.min.js"></script>
<?php if(strpos(clean_url($this->session->userdata('url')),'ligamania.cl')!==FALSE):?>
<script type="text/javascript" src="<?php echo base_url()?>scripts/swfobject/swfobject.js"></script>
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

<body MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" RIGHTMARGIN="0" BOTTOMMARGIN="0" SCROLL="NO">

    <div id="container">
        
        <div id="header">
            <?php include('layout/header.php'); ?>
        </div>
        
        <div id="wrapper">
            <div id="content">
            <?php include('layout/mensajes.php') ?>
            <?php echo $content_for_layout?>
            </div>
        </div>
        
        <div id="menu">
            <?php include('layout/menu.php'); ?>
        </div>
        
        <div id="extra">
            <?php include('layout/right.php'); ?>
        </div>
        
        <div id="footer"><?php include('layout/footer.php'); ?></div>
        
    </div>

</body>

    


</body>
</html>

