<?php

class Lostcredentials_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function get_organizationid($username){
		$this->db->from('organizations o');
		$this->db->join('loginaccounts l','l.loginaccountid=o.loginaccountid');
		$this->db->where('username',$username);
		$query = $this->db->get();
		$row = $query->row_array();
		return $row['organizationid'];
	}
	
	function webmail_exists($webmail){
		return count($this->get_link($webmail)) > 0;
	}
	
	function get_link($webmail){
		return $this->get_faculty($webmail)?:$this->get_student($webmail);
	}
	
	function get_faculty($webmail){
		$this->db->from('faculty f');
		$this->db->join('linkaccounts l','l.linkaccountid = f.useraccountid');
		$this->db->where('webmail',$webmail);
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_student($webmail){
		$this->db->from('students s');
		$this->db->join('linkaccounts l','l.linkaccountid = s.useraccountid');
		$this->db->where('webmail',$webmail);
		$query = $this->db->get();
		
		return $query->row_array();
	}
}

