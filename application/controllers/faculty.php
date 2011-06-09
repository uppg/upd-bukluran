<?php
class Faculty extends Controller {

	function Faculty()
	{
		parent::Controller();
		
		if(!$this->session->user_group_is(FACULTY_GROUPID) && !$this->session->user_group_is(OSA_GROUPID))
			redirect('login');
			
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all notification" title="Login Error"><span class="ui-icon ui-icon-alert notification-icon"></span>', '<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span></div></div>');
		$this->load->model('Osa_model');
		
		$this->sidebar_data['links'][0]['title'] = 'Announcements';
		$this->sidebar_data['links'][0]['hrefs'] = array('faculty/announcements');
		$this->sidebar_data['links'][0]['anchors'] = array('Home');
		$this->sidebar_data['links'][0]['selected'] = -1;
		$this->sidebar_data['links'][1]['title'] = 'Organizations';
		$this->sidebar_data['links'][1]['hrefs'] = array('faculty/organizations');
		$this->sidebar_data['links'][1]['anchors'] = array('Manage');
		$this->sidebar_data['links'][1]['selected'] = -1;
		$this->sidebar_data['links'][2]['title'] = 'Profile';
		$this->sidebar_data['links'][2]['hrefs'] = array('faculty/view_profile','faculty/edit_profile');
		$this->sidebar_data['links'][2]['anchors'] = array('View Profile','Edit Profile');
		$this->sidebar_data['links'][2]['selected'] = -1;
				
		$params['sidebar'] = $this->sidebar_data;
		
		$params['announcement']['title'] = "Announcements - ".$this->session->username();
		$params['announcement']['span'] = 19;
		$params['announcement']['site_link'] = 'faculty/announcements/';
		$params['announcement']['forward_link'] = 'faculty/announcements/';
		$params['announcement']['back_link'] = 'faculty/announcements/';
		
		$params['organization']['title'] = "Organizations - ".$this->session->username();
		$params['organization']['span'] = 19;
		$params['organization']['site_link'] = 'faculty/organizations/';
		$params['organization']['confirm_link'] = 'faculty/confirm/';
		$params['organization']['unconfirm_link'] = 'faculty/unconfirm/';
		
		$this->load->library('views',$params);
		$this->load->model('Faculty_model');
		$this->load->model('Organization_model');
		
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
	
	function view_profile($messages = FALSE)
	{
		$user = $this->session->userdata(USER);
		$data['has_profile'] = $this->Faculty_model->has_profile($user['facultyid']);
		if(!$data['has_profile']){
			if(!$messages)$messages = array();
			$messages[] = "Your profile is not yet set. ".anchor('faculty/edit_profile','Click here')." to create your profile."; 
		}
		$data['title'] = 'Profile - '.$this->session->username();
		$data['span'] = 19;
		$data['messages'] = $messages;
		$data['faculty'] = $this->Faculty_model->get_profile_and_details($user['facultyid']);
		
		$this->sidebar_data['links'][2]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);
		$this->load->view('faculty/view_profile',$data);
		$this->views->footer();
		$this->sidebar_data['links'][2]['selected'] = -1;
	}
	
	function edit_profile($messages = FALSE)
	{
		$user = $this->session->userdata(USER);
		$data['title'] = 'Profile - '.$this->session->username();
		$data['span'] = 19;
		$data['messages'] = $messages;
		$data['stylesheets'] = array('login.css');
		$data['faculty'] = $this->Faculty_model->get_profile_and_details($user['facultyid']);
		$data['has_profile'] = $this->Faculty_model->has_profile($user['facultyid']);
		
		$this->sidebar_data['links'][2]['selected'] = 1;
		$this->views->header($data,$this->sidebar_data);
		$this->load->view('faculty/edit_profile',$data);
		$this->views->footer();
		$this->sidebar_data['links'][2]['selected'] = -1;
	}
	
	function edit_profile_submit()
	{
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('middlename', 'Middle Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');
		$this->form_validation->set_rules('faculty_position_and_rank', 'Faculty Position and Rank', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
		$this->form_validation->set_rules('home_number', 'Home Number', 'required');
		$this->form_validation->set_rules('office_number', 'Office Number', 'required');
		$this->form_validation->set_rules('webmail', 'UP Webmail', 'required|valid_email');
		
		if (!$this->form_validation->run())
		{
			$this->edit_profile();
		}
		else
		{	
			$user = $this->session->userdata(USER);
			$faculty_profile['firstname']=$this->input->get_post('firstname');
			$faculty_profile['middlename']=$this->input->get_post('middlename');
			$faculty_profile['lastname']=$this->input->get_post('lastname');
			$faculty_profile['department']=$this->input->get_post('department');
			$faculty_profile['college']=$this->input->get_post('college');
			$faculty_profile['faculty_position_and_rank']=$this->input->get_post('faculty_position_and_rank');
			$faculty_profile['mobile_number']=$this->input->get_post('mobile_number');
			$faculty_profile['home_number']=$this->input->get_post('home_number');
			$faculty_profile['office_number']=$this->input->get_post('office_number');
			
			$faculty['webmail']=$this->input->get_post('webmail');
			
			$this->Faculty_model->save($user['facultyid'],$faculty,$faculty_profile);
			redirect('faculty/view_profile');
		}
	}
	
	function confirm($orgid, $appsemid = CURRENT_APPSEM, $facultyid = null)
	{
		if($this->session->user_group_is(FACULTY_GROUPID)){
			$user = $this->session->userdata('user');
			$facultyid = $user['facultyid'];
			$appsemid = CURRENT_APPSEM;
			if(!$this->Variable->app_is_open()){
				redirect('faculty/organizations');
			}
		}else if($this->session->user_group_is(OSA_GROUPID)){
			if($facultyid == null)
				redirect("osa/view_application/{$orgid}/{$appsemid}");
		}else{
			redirect('login');
		}	
		$this->Faculty_model->confirm($facultyid, $appsemid, $orgid);
		$org = $this->Organization_model->get_organization($orgid,$appsemid);
		if($this->session->user_group_is(FACULTY_GROUPID)){
			$this->organizations(0,array('You have successfully confirmed your membership to '.$org['orgname'].'!'));
		}else if($this->session->user_group_is(OSA_GROUPID)){
			redirect("organization/form1_faculty_adviser/{$appsemid}/{$orgid}");
		}
	}
	
	function unconfirm($orgid, $appsemid = CURRENT_APPSEM, $facultyid = null)
	{
		if($this->session->user_group_is(FACULTY_GROUPID)){
			$user = $this->session->userdata('user');
			$facultyid = $user['facultyid'];
			$appsemid = CURRENT_APPSEM;
			if(!$this->Variable->app_is_open()){
				redirect('faculty/organizations');
			}
		}else if($this->session->user_group_is(OSA_GROUPID)){
			if($facultyid == null)
				redirect("osa/view_application/{$orgid}/{$appsemid}");
		}else{
			redirect('login');
		}		
		$this->Faculty_model->unconfirm($facultyid, $appsemid, $orgid);
		$org = $this->Organization_model->get_organization($orgid,$appsemid);
		if($this->session->user_group_is(FACULTY_GROUPID)){
			$this->organizations(0,array('You have successfully removed your membership from '.$org['orgname'].'!'));
		}else if($this->session->user_group_is(OSA_GROUPID)){
			redirect("organization/form1_faculty_adviser/{$appsemid}/{$orgid}");
		}
	}
	
	function index()
	{
		$this->organizations();
	}
}

/* End of file faculty.php */
/* Location: ./application/controllers/faculty.php */