<?php
class Student extends Controller {

	function Student()
	{
		parent::Controller();
		
		if(!$this->session->user_group_is(STUDENT_GROUPID) && !$this->session->user_group_is(ORG_GROUPID) && !$this->session->user_group_is(OSA_GROUPID))
			redirect('login');
		
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->model('Student_model');
		$this->load->model('Organization_model');
		if($this->session->user_group_is(STUDENT_GROUPID)){
			$this->sidebar_data['links'][0]['title'] = 'Announcements';
			$this->sidebar_data['links'][0]['hrefs'] = array('student/announcements');
			$this->sidebar_data['links'][0]['anchors'] = array('Home');
			$this->sidebar_data['links'][0]['selected'] = -1;
			$this->sidebar_data['links'][1]['title'] = 'Organizations';
			$this->sidebar_data['links'][1]['hrefs'] = array('student/organizations');
			$this->sidebar_data['links'][1]['anchors'] = array('Manage');
			$this->sidebar_data['links'][1]['selected'] = -1;
			$this->sidebar_data['links'][2]['title'] = 'Profile';
			$this->sidebar_data['links'][2]['hrefs'] = array('student/upload');
			$this->sidebar_data['links'][2]['anchors'] = array('Upload UP ID');
			$this->sidebar_data['links'][2]['selected'] = -1;
		}else if($this->session->user_group_is(OSA_GROUPID)){
			$this->sidebar_data['links'][0]['title'] = 'Announcements';
			$this->sidebar_data['links'][0]['hrefs'] = array('osa/announcements','osa/create_announcement');
			$this->sidebar_data['links'][0]['anchors'] = array('Home','Create Announcement');
			$this->sidebar_data['links'][0]['selected'] = -1;
			$this->sidebar_data['links'][1]['title'] = 'Registration';
			$this->sidebar_data['links'][1]['hrefs'] = array('osa/organizations','osa/manage_reqs');
			$this->sidebar_data['links'][1]['anchors'] = array('Manage Organizations','Requirements');
			$this->sidebar_data['links'][1]['selected'] = -1;
			$this->sidebar_data['links'][2]['title'] = 'Application Period';
			$this->sidebar_data['links'][2]['hrefs'] = array('osa/manage_app_period');
			$this->sidebar_data['links'][2]['anchors'] = array('Manage');
			$this->sidebar_data['links'][2]['selected'] = -1;
			$this->sidebar_data['links'][3]['title'] = 'Account';
			$this->sidebar_data['links'][3]['hrefs'] = array('osa/change_password');
			$this->sidebar_data['links'][3]['anchors'] = array('Change Password');
			$this->sidebar_data['links'][3]['selected'] = -1;
		}else{
			$this->sidebar_data['links'][0]['title'] = 'Announcements';
			$this->sidebar_data['links'][0]['hrefs'] = array('organization/announcements');
			$this->sidebar_data['links'][0]['anchors'] = array('Home');
			$this->sidebar_data['links'][0]['selected'] = -1;
			$this->sidebar_data['links'][1]['title'] = 'Registration';
			$this->sidebar_data['links'][1]['hrefs'] = array('organization/forms','organization/requirements');
			$this->sidebar_data['links'][1]['anchors'] = array('Forms','Requirements');
			$this->sidebar_data['links'][1]['selected'] = -1;
			$this->sidebar_data['links'][2]['title'] = 'Account';
			$this->sidebar_data['links'][2]['hrefs'] = array('organization/change_password');
			$this->sidebar_data['links'][2]['anchors'] = array('Change Password');
			$this->sidebar_data['links'][2]['selected'] = -1;
		}
				
		//$this->sidebar_data['hrefs'] = array('student/organizations','student/upload');
		//$this->sidebar_data['anchors'] = array('Manage Organizations','Upload UP ID');		
		
		$params['sidebar'] = $this->sidebar_data;
		$params['announcement']['title'] = "Announcements - ".$this->session->username();
		$params['announcement']['span'] = 19;
		$params['announcement']['site_link'] = 'student/announcements/';
		$params['announcement']['forward_link'] = 'student/announcements/';
		$params['announcement']['back_link'] = 'student/announcements/';
		$params['organization']['title'] = "Organizations - ".$this->session->username();
		$params['organization']['span'] = 19;
		$params['organization']['site_link'] = 'student/organizations/';
		$params['organization']['confirm_link'] = 'student/confirm/';
		$params['organization']['unconfirm_link'] = 'student/unconfirm/';
		$this->load->library('views',$params);
		
		define('CURRENT_APPSEM', $this->Variable->current_application_aysem());
	}
	
	function announcements($page_no = 0,$announcement_id = -1)
	{
		$this->views->load_announcements($page_no,$announcement_id);
	}
	
	function organizations($page_no = 0, $messages = FALSE)
	{
		if(!$this->Variable->app_is_open()){
			if(!$messages)$messages = array();
			$messages[] = "The Registration Period is currently closed. You can only view your list of organizations."; 
		}
		$this->views->load_organizations($page_no, $messages);
	}
	
	function confirm($orgid, $appsemid = CURRENT_APPSEM, $studentid = null)
	{		
		if($this->session->user_group_is(STUDENT_GROUPID)){
			$user = $this->session->userdata('user');
			$studentid = $user['studentid'];
			$appsemid = CURRENT_APPSEM;
			if(!$this->Variable->app_is_open()){
				redirect('student/organizations');
			}
		}else if($this->session->user_group_is(OSA_GROUPID)){
			if($studentid == null)
				redirect("osa/view_application/{$orgid}/{$appsemid}");
		}else{
			redirect('login');
		}
		$this->Student_model->confirm($studentid, $orgid, $appsemid);
		$org = $this->Organization_model->get_organization($orgid,$appsemid);
		if($this->session->user_group_is(STUDENT_GROUPID)){
			$this->organizations(0,array('You have successfully confirmed your membership to '.$org['orgname'].'!'));
		}else if($this->session->user_group_is(OSA_GROUPID)){
			redirect("organization/form3/{$appsemid}/{$orgid}");
		}
	}
	
	function unconfirm($orgid, $appsemid = CURRENT_APPSEM, $studentid = null)
	{
		if($this->session->user_group_is(STUDENT_GROUPID)){
			$user = $this->session->userdata('user');
			$studentid = $user['studentid'];
			$appsemid = CURRENT_APPSEM;
			if(!$this->Variable->app_is_open()){
				redirect('student/organizations');
			}
		}else if($this->session->user_group_is(OSA_GROUPID)){
			if($studentid == null)
				redirect("osa/view_application/{$orgid}/{$appsemid}");
		}else{
			redirect('login');
		}	
		$this->Student_model->unconfirm($studentid, $orgid, $appsemid);
		$org = $this->Organization_model->get_organization($orgid,$appsemid);
		if($this->session->user_group_is(STUDENT_GROUPID)){
			$this->organizations(0,array('You have successfully removed your membership from '.$org['orgname'].'!'));
		}else if($this->session->user_group_is(OSA_GROUPID)){
			redirect("organization/form3/{$appsemid}/{$orgid}");
		}
	}
	
	function upload($studentid = NULL, $appsemid = CURRENT_APPSEM, $organizationid = NULL)
	{
		if($this->session->user_group_is(STUDENT_GROUPID)){
			$user_data = $this->session->userdata(USER);
			$studentid = $user_data['studentid'];
			$appsemid = CURRENT_APPSEM;
			$data['submit_url'] = "student/do_upload";
			$this->sidebar_data['links'][2]['selected'] = 0;
		}else if($this->session->user_group_is(ORG_GROUPID)){
			$appsemid = CURRENT_APPSEM;
			if(!$this->Organization_model->membership_exists($studentid, $this->session->organizationid(), $appsemid)){
				redirect('organization');
			}
			$data['submit_url'] = "student/do_upload/{$studentid}";
			$this->sidebar_data['links'][1]['selected'] = 0;
		}else{
			if(is_null($appsemid))
				redirect('osa');
			$data['submit_url'] = "student/do_upload/{$studentid}/{$appsemid}/{$organizationid}";
			$data['organizationid'] = $organizationid;
			$data['appsemid'] = $appsemid;
			$this->sidebar_data['links'][1]['selected'] = 0;
		}
		
		$data['username'] = $this->Student_model->get_studentusername($studentid);
		$data['title'] = 'Upload UP ID - '.$this->session->username();
		$data['span'] = 19;
		$data['message'] = FALSE;
		$data['stylesheets'] = array('login.css');
		$data['image'] = $this->Student_model->get_studentpicture($studentid);
		
		$this->views->header($data,$this->sidebar_data);
		$this->load->view('student/upload',$data);
		$this->views->footer();
		$this->sidebar_data['links'][2]['selected'] = -1;
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function do_upload($studentid = NULL, $appsemid = CURRENT_APPSEM, $organizationid = NULL)
	{
		if($this->session->user_group_is(STUDENT_GROUPID)){
			if(!$this->Variable->app_is_open()){
				redirect('student/upload');
			}
			$user_data = $this->session->userdata(USER);
			$studentid = $user_data['studentid'];
			$appsemid = CURRENT_APPSEM;
			$data['submit_url'] = "student/do_upload";
			$this->sidebar_data['links'][2]['selected'] = 0;
		}else if($this->session->user_group_is(ORG_GROUPID)){
			if(!$this->Variable->app_is_open()){
				redirect("student/upload/{$studentid}");
			}
			$appsemid = CURRENT_APPSEM;
			if(!$this->Organization_model->membership_exists($studentid, $this->session->organizationid(), $appsemid)){
				redirect('organization');
			}
			$data['submit_url'] = "student/do_upload/{$studentid}";
			$this->sidebar_data['links'][1]['selected'] = 0;
		}else{
			if(is_null($appsemid))
				redirect('osa');
			$data['submit_url'] = "student/do_upload/{$studentid}/{$appsemid}/{$organizationid}";
			$data['organizationid'] = $organizationid;
			$data['appsemid'] = $appsemid;
			$this->sidebar_data['links'][1]['selected'] = 0;
		}
		
		$config['upload_path'] = './uploads/';
		$config['file_name'] = $this->Student_model->get_studentusername($studentid).'-'.$appsemid;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['overwrite'] = TRUE;
		$config['max_size']	= '250';
		$this->load->library('upload', $config);
		
		$data['username'] = $this->Student_model->get_studentusername($studentid);
		$data['title'] = 'Upload UP ID - '.$this->session->username();
		$data['span'] = 19;
		$data['message'] = FALSE;
		$data['stylesheets'] = array('login.css');
		
		$user_data = $this->session->userdata(USER);
		$this->views->header($data,$this->sidebar_data);
		$this->sidebar_data['links'][2]['selected'] = -1;
		$this->sidebar_data['links'][1]['selected'] = -1;
		if (!$this->upload->do_upload())
		{
			$data['message'] = $this->upload->display_errors();	
			$data['image'] = $this->Student_model->get_studentpicture($studentid);
			$this->load->view('student/upload', $data);
		}	
		else
		{	
			$img_data = $this->upload->data();
			$this->Student_model->set_studentpicture($studentid, $img_data['file_name']);
			
			$data['message'] = "Upload Successful!";			
			$data['image'] = $this->Student_model->get_studentpicture($studentid);
			
			$this->load->view('student/upload', $data);
		}
		$this->views->footer();
	}
	
	function index()
	{
		$this->organizations();
	}
}

/* End of file student.php */
/* Location: ./application/controllers/student.php */