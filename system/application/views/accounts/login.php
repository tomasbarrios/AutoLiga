<!-- <link href="<?php echo base_url();?>css/form.css" rel="stylesheet" type="text/css" /> -->
<p class="breadcrum">
<?php echo anchor('','Inicio') ?> > 
<?php echo $title?></p>

<?php if (authentication_errors()): ?>
<div class="alert alert-error">
	<?php echo authentication_errors(); ?>
</div>	
<?php endif; ?>


<?= form_open('accounts', array('class'=>'form-horizontal')) ?>
  <fieldset>
    <legend><?php echo $title?></legend>
    <div class="control-group">
      <label for="username" class="control-label">Usuario</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="username" name="username" value="" />        
      </div>
    </div>
    <div class="control-group">
      <label for="password" class="control-label">Password</label>
      <div class="controls">
        <input type="password" class="input-xlarge" id="password" name="password" value="" />        
      </div>
    </div>    
  </fieldset>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Ingresar</button>    
  </div>
</form>