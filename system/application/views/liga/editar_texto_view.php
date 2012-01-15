<link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/tiny_mce/tiny_mce.js" ></script >
<script language="JavaScript" type="text/JavaScript">

$(document).ready(function(){

});
tinyMCE.init({
	mode : "exact",
	elements : "elm1",
	theme : "advanced",
	plugins : "advimage,advlink,media,contextmenu",
	theme_advanced_buttons1_add_before : "newdocument,separator",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,forecolor,backcolor,liststyle",
	theme_advanced_buttons2_add_before: "cut,copy,separator,",
	theme_advanced_buttons3_add_before : "",
	theme_advanced_buttons3_add : "media",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	extended_valid_elements : "hr[class|width|size|noshade]",
	file_browser_callback : "ajaxfilemanager",
	paste_use_dialog : false,
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : true,
	apply_source_formatting : true,
	force_br_newlines : true,
	force_p_newlines : false,	
	relative_urls : true
});
function ajaxfilemanager(field_name, url, type, win) {
	var ajaxfilemanagerurl = "<?php echo base_url()?>scripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
	switch (type) {
		case "image":
			break;
		case "media":
			break;
		case "flash": 
			break;
		case "file":
			break;
		default:
			return false;
	}
    tinyMCE.activeEditor.windowManager.open({
        url: "<?php echo base_url()?>scripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
        width: 782,
        height: 440,
        inline : "yes",
        close_previous : "no"
    },{
        window : win,
        input : field_name
    });
    
/*            return false;			
	var fileBrowserWindow = new Array();
	fileBrowserWindow["file"] = ajaxfilemanagerurl;
	fileBrowserWindow["title"] = "Ajax File Manager";
	fileBrowserWindow["width"] = "782";
	fileBrowserWindow["height"] = "440";
	fileBrowserWindow["close_previous"] = "no";
	tinyMCE.openWindow(fileBrowserWindow, {
	  window : win,
	  input : field_name,
	  resizable : "yes",
	  inline : "yes",
	  editor_id : tinyMCE.getWindowArg("editor_id")
	});
	
	return false;*/
}
</script>
<p class="breadcrum"><?php echo anchor('','Inicio') ?> > <?php echo anchor('admin','Administracion') ?> > Texto Home</p>
<h1 class="titulo">Texto Home</h1>

<?php echo form_open('ligas/texto_home'); ?>
<p>
<textarea id="elm1" name="texto_home" rows="30" cols="80" class="simple1" style="width: 80%">
	<?php  echo isset($texto->texto_home)?  htmlentities($texto->texto_home) : '' ?>
</textarea>
</p>
<p><?php echo form_submit(array('name'=>'enviar','id'=>'submit', 'value'=>'Guardar'));?></p>
<?php form_close(); ?> 
