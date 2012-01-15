<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="es"
    lang="es"
    dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title><?php echo $template['title']?></title>
<link href="<?php echo base_url(); ?>css/resultados.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.4.2.js"></script>
<style type="text/css">
* {
border: 1px solid red;
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

.see_more{
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
</head>
<body>

<!-- inicio box fechas -->

<div class="fecha" id="fecha_1">
	<div class="header header-fecha">
		<h3>Fecha 1 <span>22/03/2010</span><a href="#" class="see_more">mas</a></h3>
	</div>
	
	<!-- inicio box partido -->
	
	<div class="partido">
		<div id="partido_1" class="header header-partido">
			<h4>
				<span>Perros Zorros</span>
				<span class="result">12</span>
				<span>vs</span>
				<span class="result">9</span>
				<span>Gato Negro</span>				
			</h4>
			
			<div class="right-header">
				<a href="#" class="see_more">mas</a>
				<span class="definicion">Definicion
					<?php echo form_dropdown('definicion',definicion_dd(), 'Normal')?>
				</span>			
				<span class="jugado">Jugado:<input type="checkbox" name="jugado"/></span>
			</div>
		</div>
		
		<div class="detalle-partido">
			<!-- inicio box goles -->
			<h5 class="title title-goles">
			Detalle de Goles
			</h5>
			<div class="goles box">
				
				<div id="goles_local" class="box-local">
					<div class="header-goles">
						<div class="loading"></div>
						<input type="text" class="result" value="12"/>
						<span>Perros Zorros</span>
					</div>
					
					<!-- inicio detalle de goles local -->
				
					<div class="detalle-goles clear">
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					<!-- fin detalle de goles local -->
				
				</div>
				
				<div id="goles_visita" class="box-visita">
					<div class="header-goles">
						<div class="loading"></div>
						<input type="text" class="result" value="9"/>
						<span>Gato Negro</span>
					</div>
					
					<!-- inicio detalle de goles visita -->
				
					<div class="detalle-goles clear">
						<div class="gol">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					
					<!-- fin detalle de goles visita -->
					
				</div>
				
				
				<div class="clear"></div>
			</div>
			
			<!-- fin box goles -->
			
			<!-- inicio box penales -->
			<h5 class="title title-penales">Detalle de Penales</h5>
			<div class="penales box">
				<div id="penales_local" class="box-local">
					<div class="header-penales">
						<div class="loading"></div>
						<input type="text" class="result" value="12"/>
						<span>Perros Zorros</span>
					</div>
					
					<!-- inicio detalle de penales local -->
				
					<div class="detalle-penales clear">
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					<!-- fin detalle de penales local -->
				
				</div>
				
				<div id="penales_visita" class="box-visita">
					<div class="header-penales">
						<div class="loading"></div>
						<input type="text" class="result" value="9"/>
						<span>Gato Negro</span>
					</div>
					
					<!-- inicio detalle de penales visita -->
				
					<div class="detalle-penales clear">
						<div class="gol">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					
					<!-- fin detalle de penales visita -->
					
				</div>
				
				
				<div class="clear"></div>
			</div>
			
			<!-- fin box penales -->
			
			<!-- inicio box wo -->
			<h5 class="title title-wo">WO: Elija al equipo <strong>ganador</strong></h5>
			<div class="wo box">			
				<div class="box-local">
					<div class="loading"></div>
					<input type="radio" value="local" name="wo_ganador"/><span>Perros Zorros</span>
				</div>			
				<div class="box-visita">
					<div class="loading"></div>
					<input type="radio" value="visita" name="wo_ganador"/><span>Gato Negro</span>
				</div>
				<div class="clear"></div>
			</div>
			
			<!-- fin box wo -->
			
			<!-- inicio box amarillas -->		
			<h5 class="title title-amarillas">Detalle de Tarjetas Amarillas</h5>
			<div class="amarillas box">
				<div id="amarillas_local" class="box-local">
					<div class="header-amarillas">
						<div class="loading"></div>
						<input type="text" class="result" value="12"/>
						<span>Perros Zorros</span>
					</div>
					
					<!-- inicio detalle de amarillas local -->
				
					<div class="detalle-amarillas clear">
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					<!-- fin detalle de amarillas local -->
				
				</div>
				
				<div id="amarillas_visita" class="box-visita">
					<div class="header-amarillas">
						<div class="loading"></div>
						<input type="text" class="result" value="9"/>
						<span>Gato Negro</span>
					</div>
					
					<!-- inicio detalle de amarillas visita -->
				
					<div class="detalle-amarillas clear">
						<div class="gol">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					
					<!-- fin detalle de amarillas visita -->
					
				</div>
				
				<div class="clear"></div>
			</div>
			
			<!-- fin box amarillas -->
			
			<!-- inicio box rojas -->
			<h5 class="title title-rojas">Detalle de Tarjetas Rojas</h5>
			<div class="rojas box">
			<div id="rojas_local" class="box-local">
					<div class="header-rojas">
						<div class="loading"></div>
						<input type="text" class="result" value="12"/>
						<span>Perros Zorros</span>
					</div>
					
					<!-- inicio detalle de rojas local -->
				
					<div class="detalle-rojas clear">
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
						<div class="gol clear">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					<!-- fin detalle de rojas local -->
				
				</div>
				
				<div id="rojas_visita" class="box-visita">
					<div class="header-rojas">
						<div class="loading"></div>
						<input type="text" class="result" value="9"/>
						<span>Gato Negro</span>
					</div>
					
					<!-- inicio detalle de rojas visita -->
				
					<div class="detalle-rojas clear">
						<div class="gol">
							<div class="loading"></div>
							<select><option>Tomas Barrios</option></select>
						</div>
					</div>
					
					<!-- fin detalle de rojas visita -->
					
				</div>
				
				<div class="clear"></div>
			</div>
			
			<!-- fin box rojas -->
		</div>
	</div>
	
	<!-- fin box partido -->
</div>
<!-- fin box fecha -->
</body>
</html>