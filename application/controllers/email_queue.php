<?php
class Email_queue extends Controller {
	function Email_queue()
	{
		parent::Controller();
		$this->load->model('email_queue_model');
		$this->load->model('organization_model');
		$this->load->model('announcement_model');
		$this->load->model('student_model');
		$this->load->model('osa_model');
		$this->load->model('faculty_model');
		$this->load->model('variable');
		$this->load->library('emailer');
		$this->load->helper('html');
	}
	
	function index()
	{	
/*
		$orgs = $this->organization_model->get_organizations();
		$advisers = $this->organization_model->get_advisers(1,20093);
		$members = $this->organization_model->get_members_and_officers(1,20093);
		$this->email_queue_model->queue_announcement_email(1,$orgs);
		$this->email_queue_model->queue_osa_to_organization_email(1,1);
		$this->email_queue_model->queue_faculty_confirmation_email(1,$advisers);
		$this->email_queue_model->queue_member_confirmation_email(1,$members);
*/
	}
	
	function send_email($N = 5)
	{
		$result = $this->email_queue_model->get_queued_emails($N);
		$done = array();
		foreach($result as $row){
			$done[] = $row['emailqueueid'];
			switch($row['emailtypeid']){
				case MEMBER_CONFIRMATION_EMAIL:
					$data = array();
					$data['member'] = $this->student_model->get_profile($row['studentid']);
					$data['member']['position'] = $this->organization_model->get_position($row['studentid'],$row['organizationid'],$this->variable->current_application_aysem());
					$data['organization'] = $this->organization_model->get_organization($row['organizationid'],$this->variable->current_application_aysem());
					
					$subject = "Bukluran: ".$data['organization']['orgname']." has added you as a member";
					$content = $this->load->view('emails/member_confirmation',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($data['member']['webmail'],$subject,$content);
					
					$data['message'] = "{$data['organization']['orgname']} has added you as a member";
					$member = $this->organization_model->get_member($row['organizationid'], $this->variable->current_application_aysem(), $row['studentid']);
					
					$subject = "Bukluran: A message has been sent to your UP Webmail Account";
					$content = $this->load->view('emails/notification',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($member['email'],$subject,$content);
					
				break;
				case FACULTY_CONFIRMATION_EMAIL:
					$data = array();
					$data['faculty'] = $this->faculty_model->get_profile_and_details($row['facultyid']);
					$data['organization'] = $this->organization_model->get_organization($row['organizationid'],$this->variable->current_application_aysem());
/*
					$data['clarification'] = $this->organization_model->get_clarification($row['orgclarificationid']);
*/
					
					$subject = "Bukluran: ".$data['organization']['orgname']." has added you as a faculty adviser";
					$content = $this->load->view('emails/faculty_confirmation',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($data['faculty']['webmail'],$subject,$content);
					
					$data['message'] = "{$data['organization']['orgname']} has added you as a faculty adviser";
					$adviser = $this->organization_model->get_adviser($row['organizationid'], $this->variable->current_application_aysem(), $row['facultyid']);
					
					$subject = "Bukluran: A message has been sent to your UP Webmail Account";
					$content = $this->load->view('emails/notification',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($adviser['email'],$subject,$content);
				break;
				case OSA_TO_ORGANIZATION_EMAIL:
					$data = array();
					$data['clarification'] = $this->organization_model->get_clarification($row['orgclarificationid']);
					$org = $this->organization_model->get_organization_profile($row['organizationid'],$this->variable->current_application_aysem());
					$subject = "Bukluran: Message from OSA regarding your application";
					$content = $this->load->view('emails/clarification',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($org['heademail'],$subject,$content);
				break;
				case ANNOUNCEMENT_EMAIL:
					$data = array();
					$data['announcement'] = $this->announcement_model->get_announcement($row['announcementid']);
					$org = $this->organization_model->get_organization_profile($row['organizationid'],$this->variable->current_application_aysem());
					$subject = "Bukluran Announcement: ".$data['announcement']['title'];
					$content = $this->load->view('emails/announcement',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($org['heademail'],$subject,$content);
				break;
				case LOST_PASS_EMAIL:
					$org = $this->organization_model->get_organization_profile($row['organizationid'],$this->variable->current_application_aysem());
					$org['newpass'] = $this->osa_model->reset_organization_password($org['username']);
					$data['organization'] = $org;
					$subject = "Bukluran: Lost Login Details";
					$content = $this->load->view('emails/lost_pass',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($org['heademail'],$subject,$content);
				break;
				case LOST_STUDENT_CODE_EMAIL:
					$data['user'] = $this->student_model->get_profile($row['studentid']);
					$subject = "Bukluran: Lost Confirmation Code";
					$content = $this->load->view('emails/lost_code',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($data['user']['webmail'],$subject,$content);
				break;
				case LOST_FACULTY_CODE_EMAIL:
					$data['user'] = $this->faculty_model->get_profile_and_details($row['facultyid']);
					$subject = "Bukluran: Lost Confirmation Code";
					$content = $this->load->view('emails/lost_code',$data,true);
					// echo($subject.br(2).$content.br(3));
					$this->emailer->send_email($data['user']['webmail'],$subject,$content);
				break;
			}
		}
		if(count($done))
			$this->email_queue_model->done($done);
	}
}

/* End of file email_queue.php */
/* Location: ./application/controllers/email_queue.php */
