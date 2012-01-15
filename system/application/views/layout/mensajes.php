          <?php 
          	$ok = $this->session->flashdata('ok');	
          	if(!empty($ok)){          		
          		foreach ($ok as $mensajes){
          			if(!empty($mensajes)){
          				echo '<p class="box success">'.$mensajes.'</p>';
          			}
          		}
          	}
          	$error = $this->session->flashdata('error');	
          	if(!empty($error)){          		
          		foreach ($error as $mensajes){
          			if(!empty($mensajes)){
          				echo '<p class="box error">'.$mensajes.'</p>';
          			}
          		}
          	}
          ?>  