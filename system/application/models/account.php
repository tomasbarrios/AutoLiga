<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class Account extends Model {

	var $table = 'accounts';

	function Account() {
		parent::Model();
	}
	
	// get()
	// Returns a single object by id column
	function get($id) {
		$query = $this->db->get_where($this->table, array('id' => $id), 1, 0);		
		if ($query->num_rows() === 1) {
			return $query->row();
		}
		
		return NULL;
	}
	
	
	// get_by()
	// Returns a single object by a defined column
	function get_by($where) {
		$query = $this->db->get_where($this->table, $where, 1, 0);
		
		if ($query->num_rows() === 1) {
			return $query->row();
		}
		
		return NULL;
	}
	
	
	// create()
	// Creates an object
	function create($account) {
		return $this->db->insert($this->table, $account);
	}

}