<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="es"
    lang="es"
    dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title><?php echo $template['title']?></title>

<link type="text/css" href="<?php echo base_url(); ?>css/smoothness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui-1.8.13.custom.min.js"></script>

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

        $('#fechas').accordion({
            header: "h3"
        });

        $('.view_match_details').click(function(e){
            e.preventDefault();
            var div_partido = $(this).closest('.partido');
            id_partido = div_partido.attr('id');
            $.post('<?php echo base_url()?>'+'partidos/get_detalle_partido_ajax',
                {
                    id_partido: id_partido
                },
                function(data){
                    $('#'+id_partido).append(data);
                });
        });
        
    });
</script>
</head>
<body>
<div id="fechas">
    <?php foreach ($fechas as $fecha): ?>
    <!-- inicio box fecha -->
    <div class="fecha" id="fecha_<?php echo $fecha->id_fecha ?>">
            <h3><?php echo $fecha->nombre ?> <span><?php echo date('d/m/Y',strtotime($fecha->dia));?></span>
                        <!-- mas <a href="#" class="view_result_details">mas</a> fin mas-->
            </h3>
            <div class="partidos">
                <?php foreach($partidos[$fecha->id_fecha] as $partido) :?>                
                <div class="partido" id="partido_<?= $partido->id_partido?>">
                    <h4>
                        <span><?php echo $partido->local ?></span>
                        <span class="result"><?php echo $partido->goles_local ?></span>
                        <span>vs</span>
                        <span class="result"><?php echo $partido->goles_visita ?></span>
                        <span><?php echo $partido->visita ?></span>
                    </h4>
                    <div class="right-header">
                            <a href="#" class="view_match_details">mas</a>
                            <span class="definicion">Definicion
                                    <?php echo form_dropdown('definicion',definicion_dd(), 'Normal')?>
                            </span>
                            <span class="jugado">Jugado:<input type="checkbox" name="jugado" <?echo set_checkbox('jugado',1,1)?>/></span>
                    </div>

                </div>
                <?php endforeach ?>
            </div>
            
    </div>
    <!-- fin box fecha -->
    <?php endforeach ?>
</div>
</body>
</html>