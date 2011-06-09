<?php

class Email_queue_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function queue_member_confirmation_email($organizationid,$students)
	{
		if(count($students) == 0)
			return;
		foreach($students as $student){
			$id = $student['studentid'];
			// $rows[] = "{$organizationid},{$id},".MEMBER_CONFIRMATION_EMAIL;
			
			$this->db->where('organizationid',$organizationid);
			$this->db->where('studentid',$id);
			$this->db->where('emailtypeid',MEMBER_CONFIRMATION_EMAIL);
			$this->db->from('email_queue');
			if($this->db->count_all_results()==0){
				$this->db->set('organizationid',$organizationid);
				$this->db->set('studentid',$id);
				$this->db->set('emailtypeid',MEMBER_CONFIRMATION_EMAIL);
				$this->db->insert('email_queue');
			}
		}
		// $values = "(".implode('),(',$rows).")";
		// $sql = "INSERT INTO email_queue (organizationid, studentid, emailtypeid) VALUES {$values}";
		// return $this->db->simple_query($sql);
	}
	
	function queue_faculty_confirmation_email($organizationid,$advisers)
	{
		if(count($advisers) == 0)
			return;
		foreach($advisers as $adviser){
			$id = $adviser['facultyid'];
			// $rows[] = "{$organizationid},{$id},".FACULTY_CONFIRMATION_EMAIL;
			
			$this->db->where('organizationid',$organizationid);
			$this->db->where('facultyid',$id);
			$this->db->where('emailtypeid',FACULTY_CONFIRMATION_EMAIL);
			$this->db->from('email_queue');
			if($this->db->count_all_results()==0){
				$this->db->set('organizationid',$organizationid);
				$this->db->set('facultyid',$id);
				$this->db->set('emailtypeid',FACULTY_CONFIRMATION_EMAIL);
				$this->db->insert('email_queue');
			}
		}
		// $values = "(".implode('),(',$rows).")";
		// $sql = "INSERT INTO email_queue (organizationid, facultyid, emailtypeid) VALUES {$values}";
		// return $this->db->simple_query($sql);
	}
	
	function queue_osa_to_organization_email($orgclarificationid,$organizationid)
	{
		$this->db->insert('email_queue',array(
			'orgclarificationid'=>$orgclarificationid,
			'organizationid'=>$organizationid,
			'emailtypeid'=>OSA_TO_ORGANIZATION_EMAIL
		));
	}
	
	function queue_announcement_email($announcementid,$organizations)
	{
		if(count($organizations) == 0)
			return;
		foreach($organizations as $org){
			$id = $org['organizationid'];
			// $rows[] = "{$announcementid},{$id},".ANNOUNCEMENT_EMAIL;
			
			$this->db->where('announcementid',$announcementid);
			$this->db->where('organizationid',$id);
			$this->db->where('emailtypeid',ANNOUNCEMENT_EMAIL);
			$this->db->from('email_queue');
			if($this->db->count_all_results()==0){
				$this->db->set('announcementid',$announcementid);
				$this->db->set('organizationid',$id);
				$this->db->set('emailtypeid',ANNOUNCEMENT_EMAIL);
				$this->db->insert('email_queue');
			}
		}
		// $values = "(".implode('),(',$rows).")";
		// $sql = "INSERT INTO email_queue (announcementid, organizationid, emailtypeid) VALUES {$values}";
		// return $this->db->simple_query($sql);
	}
	
	function queue_lost_password_email($organizationid){
		$this->db->from('email_queue');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('emailtypeid',LOST_PASS_EMAIL);
		if($this->db->count_all_results()==1){
			$this->db->where('organizationid',$organizationid);
			$this->db->where('emailtypeid',LOST_PASS_EMAIL);
			$this->db->update('email_queue',array('sent'=>'false'));
		}else{
			$this->db->set('organizationid',$organizationid);
			$this->db->set('emailtypeid',LOST_PASS_EMAIL);
			$this->db->insert('email_queue');
		}
	}
	
	function queue_lost_faculty_hashcode_email($facultyid){
		$this->db->from('email_queue');
		$this->db->where('facultyid',$facultyid);
		$this->db->where('emailtypeid',LOST_FACULTY_CODE_EMAIL);
		if($this->db->count_all_results()==1){
			$this->db->where('facultyid',$facultyid);
			$this->db->where('emailtypeid',LOST_FACULTY_CODE_EMAIL);
			$this->db->update('email_queue',array('sent'=>'false'));
		}else{
			$this->db->set('facultyid',$facultyid);
			$this->db->set('emailtypeid',LOST_FACULTY_CODE_EMAIL);
			$this->db->insert('email_queue');
		}
	}
	
	function queue_lost_student_hashcode_email($studentid){
		$this->db->from('email_queue');
		$this->db->where('studentid',$studentid);
		$this->db->where('emailtypeid',LOST_STUDENT_CODE_EMAIL);
		if($this->db->count_all_results()==1){
			$this->db->where('studentid',$studentid);
			$this->db->where('emailtypeid',LOST_STUDENT_CODE_EMAIL);;
			$this->db->update('email_queue',array('sent'=>'false'));
		}else{
			$this->db->set('studentid',$studentid);
			$this->db->set('emailtypeid',LOST_STUDENT_CODE_EMAIL);
			$this->db->insert('email_queue');
		}
	}
	
	function get_queued_emails($limit = 5)
	{
		$this->db->from('email_queue q');
		$this->db->join('email_types t','q.emailtypeid = t.emailtypeid');
		$this->db->where('sent','false');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function done($ids)
	{
		$this->db->where_in('emailqueueid',$ids,false);
		$this->db->update('email_queue', array('sent'=>'true')); 
	}
}

