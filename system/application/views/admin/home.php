<p class="breadcrum"><?php echo anchor('','Inicio') ?> > Administracion</p>
<h1 class="titulo">Administracion</h1>
<?php if ($goles_pendientes != null) : ?>
<div id="pending">
    <p>Tienes goles sin asignar a jugadores, <a href="<?php echo base_url()?>partidos/resultados">actualiza esta información.</a>
    </p>
    </div>
<?php endif ?>
<div id="admin_menu" style="margin: 0 auto; width: 500px;">
<!-- <p class="admin_link"><?php echo anchor('ligas/temporada','Nueva Temporada');?></p> -->
<p class="admin_link"><?php echo anchor('copas/admin','Fases');?></p>
<p class="admin_link"><?php echo anchor('grupos/admin','Grupos');?></p>
<p class="admin_link"><?php echo anchor('equipos/admin','Equipos');?></p>
<p class="admin_link"><?php echo anchor('fechas/admin','Fechas');?></p>
<p class="admin_link"><?php echo anchor('partidos/admin','Partidos');?></p>
<p class="admin_link"><?php echo anchor('partidos/resultados','Resultados');?></p>
<p class="admin_link"><?php echo anchor('suspensiones/admin','Suspensiones');?></p>

<p class="admin_link"><?php echo anchor('sponsors/admin','Sponsors');?></p>
<p class="admin_link"><?php echo anchor('premios/admin','Premios');?></p>

<p class="admin_link"><?php echo anchor('ligas/texto_home','Texto Home');?></p>

<p class="admin_link"><?php echo anchor('ligas/admin','Datos Liga');?></p>
<p class="admin_link"><?php echo anchor('accounts/logout','Salir del sistema');?></p>
</div>