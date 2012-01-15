<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="es"
    lang="es"
    dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title><?php echo $template['title']?></title>
<link href="<?php echo base_url(); ?>css/resultados.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url(); ?>css/smoothness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui-1.8.13.custom.min.js"></script>

<style type="text/css">
* {
margin: 0 0;
padding: 0 0;
}
body {
font-family: Arial, Helvetica, sans-serif;
color: #333;
margin: 0 auto;
}
.fecha{
width: 720px;
margin: 0 auto;
}

.view_result_details, .view_match_details{
float:right;
background: url(../imagenes/iconos/upcoming-work.png);
width:32px;
height: 32px;
text-indent: -10000px;
}
.header_fecha{
overflow: auto;
}
.header{
height: 32px;
}
div.box-local{
float: left;
width: 300px;
}
div.partido, div.detalle-partido{
width:95%;
margin: 0 auto;
}

div.box-local *{
float:right;
}
div.box-visita{
float:right;
width: 300px;
}

div.box-visita *{
float: left;
}


.clear{
clear: both;
}

.loading{
visibility:hidden;
height: 20px;
width:32px;
background: url(../imagenes/spinner.gif) no-repeat center;
}
.header-partido h4{
float:left;
}
.header-partido > *{
	height: 100%; 
	vertical-align:middle;
}
.header-partido{
	height: 3em;
}
.header-partido div span, .header-partido h4 span{
  height: 100%;
  line-height:100%;
}
.right-header{
float:right;
}
/*fin layout*/

/* inicio formato*/
.amarillas{
background-color: #fbff87;
}
.rojas{
background-color: #ffb3b3;
}
.goles,.penales,.wo{
background-color: #d4e980;
}

.header-partido{
background-color: #3e3a3a;
color: white;
}
.box{
padding: 10px;
}
.title{
padding: 5px 10px;
}
.title-goles,.title-penales,.title-wo{
background-color: #a5b563;
}
.title-amarillas{
background-color: #ecf07f;
}
.title-rojas{
background-color: #e09d9d;
}
.header-goles{
	padding:0 0 10px 0;
}

.header-goles{

}

.header-goles span{
height: 25px;
line-height: 25px;
padding: 0 10px;
}

input.result{
height: 25px;
width: 25px;
text-align: center;
}

.detalle-partido select{
width: 150px;
}
select{
padding: 5px;
height: 30px;
line-height:30px;

margin-bottom:5px;
}
.detalle-goles option{
line-height:30px;
padding: 5px;

}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.view_result_details').click(function(e){
            e.preventDefault();
            var div_fecha = $(this).closest('.fecha');
            id_fecha = div_fecha.attr('id');
            $.post('<?php echo base_url()?>'+'partidos/get_partidos_ajax',
                {
                    id_fecha: id_fecha
                },
                function(data){
                    div_fecha.append(data['partials']['partidos']);
                },
                'json');
        });

        $('.fecha').accordion({header: "h3"});
    });
</script>
</head>
<body>

<?php foreach ($fechas as $fecha): ?>
<!-- inicio box fecha -->
<div class="fecha" id="<?php echo $fecha->id_fecha ?>">
	<div class="header header-fecha">
		<h3><?php echo $fecha->nombre ?> <span><?php echo date('d/m/Y',strtotime($fecha->dia));?></span>
                    <!-- mas <a href="#" class="view_result_details">mas</a> fin mas-->
                </h3>
	</div>
</div>
<!-- fin box fecha -->
<?php endforeach ?>
</body>
</html>