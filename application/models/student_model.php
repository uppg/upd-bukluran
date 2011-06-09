<?php

class Student_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function get_organizations($studentid, $aysem, $limit = 20, $offset = 0){
		$this->db->from('organizations o');
		$this->db->join('orgmemberships om', 'om.organizationid = o.organizationid');
		$this->db->where('studentid', $studentid);
		$this->db->where('appsemid',$aysem);
		$this->db->order_by('orgname');
		//$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_profile($studentid){
		$this->db->from('students s');
		$this->db->join('linkaccounts l','l.linkaccountid = s.useraccountid');
		$this->db->where('studentid',$studentid);
		
		$query = $this->db->get();
		return($query->row_array());	
	}
	
	function confirm($studentid, $orgid, $aysem){
		$this->db->where('studentid',$studentid);
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$aysem);
		$this->db->update('orgmemberships',array('confirmed'=>'true'));
	}
	
	function unconfirm($studentid, $orgid, $aysem){
		$this->db->where('studentid',$studentid);
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$aysem);
		$this->db->update('orgmemberships',array('confirmed'=>'false'));
	}
	
	function set_studentpicture($studentid,$path){
		if($this->get_studentpicture($studentid)){
			$this->db->where('studentid', $studentid);
			$this->db->update('studentpictures',array('filepath'=>$path));
		}else{
			$this->db->insert('studentpictures',array('studentid'=>$studentid,'filepath'=>$path));
		}
	}
	
	function has_studentpicture($studentid){
		$this->db->from('studentpictures');
		$this->db->where('studentid',$studentid);
		return $this->db->count_all_results() == 1;
	}
	
	function get_studentpicture($studentid){
		$this->db->from('studentpictures p');
		$this->db->where('studentid', $studentid);
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function get_studentusername($studentid){
		$this->db->from('students');
		$this->db->where('studentid', $studentid);
		$query = $this->db->get();
		$row = $query->row_array();
		$webmail = $row['webmail'];
		
		$webmail = explode('@',$webmail);
		return $webmail[0];
	}
}

