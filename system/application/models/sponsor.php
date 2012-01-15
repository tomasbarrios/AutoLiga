<?php
class Sponsor extends Model{
	
	function __construct(){
		parent::Model();
	}
	
	function eliminar($id_sponsor){
		$this->db->where('id_sponsor',$id_sponsor);
		$this->db->delete('sponsors');
	}
	
	function set_posicion($id_sponsor, $posicion){
		$this->db->where('id_sponsor', $id_sponsor);
		$this->db->set('posicion', $posicion);
		$this->db->update('sponsors');
		$this->firephp->info($this->db->last_query());
	}
	
	function get_all(){
		$this->db->where('id_liga',$this->liga->get_id_actual());
		$this->db->order_by('posicion');
		$sponsors = $this->db->get('sponsors')->result();
		$this->firephp->info($this->db->last_query());
		$this->firephp->info($sponsors);
		return $sponsors;
	}
	
	function get_dropdown(){
		$sponsors = $this->get_all();
		$sponsor_dd = array(''=>'Seleccione');
		foreach ($sponsors as $sponsor){
			$sponsor_dd[$sponsor->id_sponsor] = $sponsor->nombre;
		}
		return $sponsor_dd;
	}
	
	function guardar(){
		$id_sponsor = $this->input->post('id_sponsor');
		$id_liga = $this->liga->get_id_actual();
		$nombre = $this->input->post('nombre');
		$url = $this->input->post('url');		
		$sponsor = array('nombre'=>$nombre,'url'=>$url, 'id_liga'=>$id_liga);
		
		if(!empty($id_sponsor)){
			//update
			$this->db->where('id_sponsor',$id_sponsor);
			$this->db->update('sponsors',$sponsor);			
		} else {
			//nuevo
			$this->db->insert('sponsors',$sponsor);
			$id_sponsor = $this->db->insert_id();
		}
		$this->firephp->info($this->db->last_query());
		return $id_sponsor;		
	}
}
?>
