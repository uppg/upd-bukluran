<?php

class Organization_model extends Model{

	public function __construct(){
		parent::__construct();
		$this->load->helper('password');
	}
	
	function get_organization($organizationid, $appsemid){
		$this->db->from('organizations o');
		$this->db->join('orgprofiles p','o.organizationid = p.organizationid');
		$this->db->join('(SELECT orgcategoryid, description AS orgcategorydesc FROM orgcategories) cat','cat.orgcategoryid = p.orgcategoryid');
		$this->db->join('(SELECT orgstatusid, description AS orgstatusdesc FROM orgstatuses) stat','stat.orgstatusid = p.orgstatusid');
		$this->db->where('o.organizationid', $organizationid);
		$this->db->where('p.appsemid', $appsemid);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function get_organizations(){
		$this->db->from('organizations o');
		$this->db->join('loginaccounts l', 'o.loginaccountid = l.loginaccountid', 'right');
		$this->db->where('groupid', ORG_GROUPID);
		$this->db->order_by('orgname');
		$this->db->order_by('username');
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_organization_profile($orgid, $sem){
		$this->db->from('organizations o');
		$this->db->join('loginaccounts l', 'o.loginaccountid = l.loginaccountid', 'right');
		$this->db->join('orgprofiles p', 'p.organizationid = o.organizationid');
		$this->db->where('p.appsemid', $sem);
		$this->db->where('p.organizationid', $orgid);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function get_organization_profiles($aysem){
		$this->db->from('organizations o');
		$this->db->join('loginaccounts l', 'o.loginaccountid = l.loginaccountid', 'right');
		$this->db->join('orgprofiles p', 'p.organizationid = o.organizationid');
		$this->db->where('groupid', ORG_GROUPID);
		$this->db->where('p.appsemid', $aysem);
		$this->db->order_by('orgname');
		$this->db->order_by('username');
		
		$query = $this->db->get();
		return($query->result_array());
		// $this->db->from('orgprofiles p');
		// $this->db->where('p.appsemid', $aysem);
		
		// $query = $this->db->get();
		// return($query->result_array());
	}
	
	function get_orgstatus($orgstatusid){
		$this->db->from('orgstatuses');
		$this->db->where('orgstatusid', $orgstatusid);
		
		$query = $this->db->get();
		$row = $query->row_array();
		return($row['description']);
	}
	
	function get_orgstatuses(){
		$this->db->from('orgstatuses');
		
		$query = $this->db->get();
		return($query->result_array());
	}
		
	function get_orgcategory($orgcategoryid){
		$this->db->from('orgcategories');
		$this->db->where('orgcategoryid', $orgcategoryid);
		
		$query = $this->db->get();
		$row = $query->row_array();
		return($row['description']);
	}
	
	function get_orgcategories(){
		$this->db->from('orgcategories');		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_members_and_officers($organizationid, $appsemid){
		$this->db->select('s.studentid,useraccountid,webmail,organizationid,m.appsemid,email,position,confirmed,studentpictureid,filepath');
		$this->db->from('students s');
		$this->db->join('orgmemberships m', 's.studentid = m.studentid');
		$this->db->join('studentpictures p','m.studentid=p.studentid','left');
		$this->db->where('organizationid', $organizationid);
		$this->db->where('m.appsemid', $appsemid);
		//$this->db->where('position', NULL);
		$this->db->order_by('webmail', 'asc');
		
		$query = $this->db->get();
		return($query->result_array());	
	}
	
	function get_members($organizationid, $appsemid){
		$this->db->select('s.studentid,useraccountid,webmail,organizationid,m.appsemid,email,position,confirmed,studentpictureid,filepath');
		$this->db->from('students s');
		$this->db->join('orgmemberships m', 's.studentid = m.studentid');
		$this->db->join('studentpictures p','m.studentid=p.studentid','left');
		$this->db->where('organizationid', $organizationid);
		$this->db->where('m.appsemid', $appsemid);
		$this->db->where('position', NULL);
		$this->db->order_by('webmail', 'asc');
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_officers($organizationid, $appsemid){
		$this->db->select('s.studentid,useraccountid,webmail,organizationid,m.appsemid,email,position,confirmed,studentpictureid,filepath');
		$this->db->from('students s');
		$this->db->join('orgmemberships m', 's.studentid = m.studentid');
		$this->db->join('studentpictures p','m.studentid=p.studentid','left');
		$this->db->where('organizationid', $organizationid);
		$this->db->where('m.appsemid', $appsemid);
		$this->db->where('position IS NOT NULL', NULL, FALSE);
		$this->db->order_by('webmail', 'asc');
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function roster_add_student($organizationid, $appsemid, $webmail, $email, $position = NULL){
		$student = $this->assertive_get_student($webmail, $email);
		$studentid = $student['studentid'];
		
		if($this->membership_exists($studentid, $organizationid, $appsemid))
			return(FALSE);
		
		$this->insert_membership($studentid, $organizationid, $appsemid, $email, $position);
		
		return(TRUE);
	}
	
	function assertive_get_student($webmail, $email = NULL){
		if(!$this->student_exists($webmail))
			$this->insert_student($webmail, $email);
			
		return($this->get_student($webmail));
	}

	function get_student($webmail){
		$this->db->from('students');
		$this->db->where('webmail', $webmail);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function insert_student($webmail, $email){
		$linkaccount = $this->insert_link_account(STUDENT_GROUPID);
		
		$this->db->set('webmail', $webmail);
		$this->db->set('useraccountid', $linkaccount['linkaccountid']);
		$this->db->insert('students');
	}
	
	function insert_membership($studentid, $organizationid, $appsemid, $email, $position = NULL){
		$this->db->set('studentid', $studentid);
		$this->db->set('organizationid', $organizationid);
		$this->db->set('appsemid', $appsemid);
		$this->db->set('email', $email);
		$this->db->set('position', $position);
		$this->db->insert('orgmemberships');
	}
	
	function student_exists($webmail){
		$this->db->from('students');
		$this->db->where('webmail', $webmail);
		
		return($this->db->count_all_results() > 0);
	}
	
	function membership_exists($studentid, $organizationid, $appsemid){
		$this->db->from('orgmemberships');
		$this->db->where('studentid', $studentid);
		$this->db->where('organizationid', $organizationid);
		$this->db->where('appsemid', $appsemid);
		
		return($this->db->count_all_results() > 0);
	}
	
	function get_advisers($orgid, $sem){
		//$sem = $this->Variable->current_app_aysem();
		$this->db->from('faculty f');
		$this->db->join('orgadvisers a', 'f.facultyid = a.facultyid');
		$this->db->where('a.organizationid', $orgid);
		$this->db->where('a.appsemid', $sem);
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_clarifications($orgid, $aysem){
		$this->db->from('orgclarifications');
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$aysem);
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_clarification($id){
		$this->db->from('orgclarifications');
		$this->db->where('orgclarificationid',$id);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function create_clarification($orgid,$aysem,$description){
		$arr = array(
			'appsemid' => $aysem,
			'organizationid' => $orgid,
			'description' => $description
		);
		$this->db->insert('orgclarifications',$arr);
		
		$query = $this->db->get_where('orgclarifications',$arr);
		return $query->row_array();
	}
	
	function edit_clarification($id,$description){
		$this->db->where('orgclarificationid',$id);
		$this->db->update('orgclarifications',array('description' => $description));
	}
	
	function delete_clarification($id){
		$this->db->where('orgclarificationid',$id);
		$this->db->delete('email_queue');
		
		$this->db->where('orgclarificationid',$id);
		$this->db->delete('orgclarifications');
	}
	
	function get_position($studentid, $organizationid, $appsemid){
		$this->db->from('orgmemberships');
		$this->db->where('studentid', $studentid);
		$this->db->where('organizationid', $organizationid);
		$this->db->where('appsemid', $appsemid);
		$query = $this->db->get();
		$row = $query->row_array();
		return $row['position'];
	}
	
	function add_faculty($organizationid, $appsemid, $webmail, $email){
		$faculty = $this->assertive_get_faculty($webmail);
		$facultyid = $faculty['facultyid'];
		
		if($this->adviser_exists($facultyid, $organizationid, $appsemid))
			return(FALSE);
		
		$this->insert_adviser($facultyid, $organizationid, $appsemid, $email);
		
		return(TRUE);
	}
	
	function adviser_exists($facultyid, $organizationid, $appsemid){
		$this->db->from('orgadvisers');
		$this->db->where('facultyid', $facultyid);
		$this->db->where('organizationid', $organizationid);
		$this->db->where('appsemid', $appsemid);
		
		return($this->db->count_all_results() > 0);
	}
	
	function insert_adviser($facultyid, $organizationid, $appsemid, $email){
		$this->db->set('facultyid', $facultyid);
		$this->db->set('organizationid', $organizationid);
		$this->db->set('appsemid', $appsemid);
		$this->db->set('email', $email);
		$this->db->insert('orgadvisers');
	}

	function assertive_get_faculty($webmail){
		if(!$this->faculty_exists($webmail))
			$this->insert_faculty($webmail);
			
		return($this->get_faculty($webmail));
	}
	
	function get_faculty($webmail){
		$this->db->from('faculty');
		$this->db->where('webmail', $webmail);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function insert_faculty($webmail){
		$linkaccount = $this->insert_link_account(FACULTY_GROUPID);
		
		$this->db->set('webmail', $webmail);
		$this->db->set('useraccountid', $linkaccount['linkaccountid']);
		$this->db->insert('faculty');
	}
	
	function faculty_exists($webmail){
		$this->db->from('faculty');
		$this->db->where('webmail', $webmail);
		
		return($this->db->count_all_results() > 0);
	}
	
	function save_organization($orgid,$orgname){
		$this->db->where('organizationid',$orgid);
		$this->db->update('organizations',array('orgname'=>$orgname));
	}
	
	function save_organization_profile($organizationid,$appsemid,$profile){
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$this->db->update('orgprofiles',$profile);
	}
	
	function delete_member($organizationid,$studentid,$appsemid){
		$this->db->where('organizationid',$organizationid);
		$this->db->where('studentid',$studentid);
		$this->db->where('appsemid',$appsemid);
		$this->db->delete('orgmemberships');
	}
	
	function delete_adviser($organizationid,$facultyid,$appsemid){
		$this->db->where('organizationid',$organizationid);
		$this->db->where('facultyid',$facultyid);
		$this->db->where('appsemid',$appsemid);
		$this->db->delete('orgadvisers');
	}
	
	function link_account_code_exists($code){
		$this->db->from('linkaccounts');
		$this->db->where('hashcode',$code);
		
		return($this->db->count_all_results() > 0);
	}
	
	function get_link_account($hashcode){
		$this->db->from('linkaccounts');
		$this->db->where('hashcode',$hashcode);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function insert_link_account($groupid){
		$hashcode = generate_password(16);
		while($this->link_account_code_exists($hashcode)){
			$hashcode = generate_password(16);
		}
		$this->db->set('hashcode', $hashcode);
		$this->db->set('groupid', $groupid);
		$this->db->insert('linkaccounts');
		
		return $this->get_link_account($hashcode);
	}
	
	function get_member($organizationid, $appsemid, $studentid)
	{
		$this->db->select('s.studentid,useraccountid,webmail,organizationid,m.appsemid,email,position,confirmed,studentpictureid,filepath');
		$this->db->from('students s');
		$this->db->join('orgmemberships m', 's.studentid = m.studentid');
		$this->db->join('studentpictures p','m.studentid=p.studentid','left');
		$this->db->where('organizationid', $organizationid);
		$this->db->where('m.appsemid', $appsemid);
		$this->db->where('s.studentid', $studentid);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_adviser($organizationid, $appsemid, $facultyid)
	{
		$this->db->from('orgadvisers');
		$this->db->where('organizationid', $organizationid);
		$this->db->where('appsemid', $appsemid);
		$this->db->where('facultyid', $facultyid);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function save_acknowledged($organizationid,$appsemid,$acknowledged){
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$this->db->set('acknowledged',$acknowledged);
		$this->db->update('orgprofiles');
	}
}
