<?php

class Faculty_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function get_organizations($facultyid, $aysem, $limit = 20, $offset = 0){
		$this->db->from('organizations o');
		$this->db->join('orgadvisers oa', 'oa.organizationid = o.organizationid');
		$this->db->where('facultyid', $facultyid);
		$this->db->where('appsemid',$aysem);
		$this->db->order_by('orgname');
		//$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function has_profile($facultyid){
		$this->db->from('facultyprofile');
		$this->db->where('facultyid',$facultyid);
		return $this->db->count_all_results() == 1;
	}
	
	function get_profile($facultyid){
		$this->db->from('facultyprofile');
		$this->db->where('facultyid',$facultyid);
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function get_faculty_details($facultyid){
		$this->db->from('faculty f');
		$this->db->join('linkaccounts l','l.linkaccountid = f.useraccountid');
		$this->db->where('facultyid',$facultyid);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_profile_and_details($facultyid){
		$res1 = $this->get_profile($facultyid);
		if(!array_key_exists('firstname',$res1)){$res1['firstname']="";}
		if(!array_key_exists('middlename',$res1)){$res1['middlename']="";}
		if(!array_key_exists('lastname',$res1)){$res1['lastname']="";}
		if(!array_key_exists('department',$res1)){$res1['department']="";}
		if(!array_key_exists('college',$res1)){$res1['college']="";}
		if(!array_key_exists('faculty_position_and_rank',$res1)){$res1['faculty_position_and_rank']="";}
		if(!array_key_exists('mobile_number',$res1)){$res1['mobile_number']="";}
		if(!array_key_exists('home_number',$res1)){$res1['home_number']="";}
		if(!array_key_exists('office_number',$res1)){$res1['office_number']="";}
		$res2 = $this->get_faculty_details($facultyid);
		return array_merge($res1,$res2);
	}
	
	function save($facultyid, $faculty, $faculty_profile){
		$this->db->where('facultyid',$facultyid);
		$this->db->update('faculty',$faculty);
		
		if($this->has_profile($facultyid)){
			$this->db->where('facultyid',$facultyid);
			$this->db->update('facultyprofile',$faculty_profile);
		}else{
			$faculty_profile['facultyid'] = $facultyid;
			$this->db->insert('facultyprofile',$faculty_profile);
		}
	}
	
	function confirm($facultyid, $aysem, $orgid){
		$this->db->where('facultyid',$facultyid);
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$aysem);
		$this->db->update('orgadvisers',array('confirmed'=>'true'));
	}
	
	function unconfirm($facultyid, $aysem, $orgid){
		$this->db->where('facultyid',$facultyid);
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$aysem);
		$this->db->update('orgadvisers',array('confirmed'=>'false'));
	}
}


