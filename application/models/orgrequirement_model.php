<?php

class Orgrequirement_model extends Model{

	public function __construct(){
		parent::__construct();
	}

	function get_requirements_appsem($organizationid, $appsemid){
		$this->db->select('r.requirementid, name, submittedon, comments');
		$this->db->distinct();
		$this->db->from('requirements r');
		$this->db->join('orgsubmittedrequirements osr', "r.requirementid = osr.requirementid and organizationid = {$organizationid}", 'left');
		$this->db->where('appsemid', $appsemid);
		$this->db->order_by('name');
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_requirement($organizationid, $requirementid){
		$this->db->select('r.requirementid, appsemid, name, description, submittedon, comments');
		$this->db->from('requirements r');
		$this->db->join('orgsubmittedrequirements osr', 'r.requirementid = osr.requirementid', 'left');
		$this->db->where('r.requirementid', $requirementid);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function update_requirement($organizationid, $requirementid, $submitted, $submittedon, $comments){
		if($submitted){
			$this->db->set('submittedon', $submittedon);
			$this->db->set('comments', $comments);
			
			if($this->requirement_exists($organizationid, $requirementid)){
				$this->db->where('organizationid', $organizationid);
				$this->db->where('requirementid', $requirementid);
				$this->db->update('orgsubmittedrequirements');
			}
			else{
				$this->db->set('organizationid', $organizationid);
				$this->db->set('requirementid', $requirementid);
				$this->db->insert('orgsubmittedrequirements');
			}
		}
		else{
			$this->db->where('organizationid', $organizationid);
			$this->db->where('requirementid', $requirementid);
			$this->db->delete('orgsubmittedrequirements');
		}
	}
	
	function requirement_exists($organizationid, $requirementid){
		$this->db->from('orgsubmittedrequirements');
		$this->db->where('organizationid', $organizationid);
		$this->db->where('requirementid', $requirementid);
		
		return($this->db->count_all_results() > 0);
	}
}
