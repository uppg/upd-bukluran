<?php

class Login_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function authenticate_login($username, $password, $ishashed = false){
		$this->db->from('loginaccounts l');
		$this->db->join('groups g', 'l.groupid = g.groupid');
		// $this->db->join('organizations o', 'l.loginaccountid = o.loginaccountid', 'left');
		// $this->db->join('orgprofiles p', 'p.organizationid = o.organizationid', 'left');
		$this->db->where('username', $username);
		$this->db->where('password', $ishashed?$password:md5($password));
		
		$query = $this->db->get();
		$row = $query->row_array();
		
		if(array_key_exists('groupid', $row) && $row['groupid'] == ORG_GROUPID){
			$this->db->from('organizations');
			$this->db->where('loginaccountid',$row['loginaccountid']);
			$query = $this->db->get();
			$row2 = $query->row_array();
			$row = array_merge($row2,$row);
		}
		return $row;
	}
	
	function authenticate_link($link){
		$this->db->from('linkaccounts l');
		$this->db->join('groups g', 'l.groupid = g.groupid');
		$this->db->where('hashcode', $link);

		$res = $this->db->get();
		if($res->num_rows() <= 0){
			return false;
		}
		$res = $res->row_array();
		
		if($res['groupname'] == 'faculty'){
			$this->db->from('faculty');
		}
		else if($res['groupname'] == 'student'){
			$this->db->from('students');
		}
		
		$this->db->where('useraccountid',$res['linkaccountid']);
		$res2 = $this->db->get();
		$res2 = $res2->row_array();
		
		if($res['groupname'] == 'faculty'){
			$res['facultyid'] = $res2['facultyid'];
		}
		else if($res['groupname'] == 'student'){
			$res['studentid'] = $res2['studentid'];
		}
		$res['webmail'] = $res2['webmail'];
		$res['username'] = explode('@',$res['webmail']);
		$res['username'] = $res['username'][0];
		// $res['email'] = $res2['email'];
		
		return($res);
	}
	
}

