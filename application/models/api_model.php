<?php

class Api_model extends Model{
	function authenticate($apikey){
		$this->db->from('apikeys');
		$this->db->where('apikey',$apikey);
		return $this->db->count_all_results() == 1;
	}
}