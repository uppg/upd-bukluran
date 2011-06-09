<?php

define('ACTION_ADD_REQ', 'addreq');
define('ACTION_EDIT_REQ', 'editreq');

class Osa extends Controller {
	
	private $sidebar_data;

	function __construct(){
		parent::__construct();
		
		if(!$this->session->user_group_is(OSA_GROUPID))
			redirect('login');

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
		
		$this->sidebar_data['hrefs'] = array('osa/announcements','osa/create_announcement', 'osa/organizations', 'osa/manage_reqs', 'osa/manage_app_period');
		$this->sidebar_data['anchors'] = array('Announcements','Create Announcement', 'Manage Organizations', 'Manage Requirements', 'Manage Application Period');
		
		$this->load->helper('html');
		$this->load->helper('form');
		
		$this->load->model('Osa_model');
		$this->load->model('Variable');
		$this->load->model('organization_model');
		$this->load->model('email_queue_model');
		$this->load->model('orgregistration_model');
		
		define('CURRENT_APPSEM', $this->Variable->current_application_aysem());
		
		$params['sidebar'] = $this->sidebar_data;
		
		$params['announcement']['title'] = "Announcements - OSA";
		$params['announcement']['span'] = 19;
		$params['announcement']['site_link'] = 'osa/announcements/';
		$params['announcement']['forward_link'] = 'osa/announcements/';
		$params['announcement']['back_link'] = 'osa/announcements/';
		
		$this->load->library('views',$params);
		$this->load->model('announcement_model');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all notification" title="Login Error"><span class="ui-icon ui-icon-alert notification-icon"></span>', '<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span></div></div>');
	}
	
	function index(){
		$this->organizations();
	}
	
	function create_announcement(){
		$data['title'] = "Create Announcement - OSA";	
		
		$fckeditorConfig = array(
			'instanceName' => 'content',
			'BasePath' => base_url().'system/plugins/fckeditor/',
			'ToolbarSet' => 'Basic',
			'Width' => '100%',
			'Height' => '400',
			'Value' => ''
			);
		
		$content_data['announcement']['content'] = '';
		$content_data['announcement']['title'] = '';
		$content_data['title'] = 'Create Announcement';
		$content_data['submit_url'] = 'osa/create_announcement_submit';
		
		$this->load->library('fckeditor', $fckeditorConfig);
		
		$this->sidebar_data['links'][0]['selected'] = 1;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/create_announcement',$content_data);
		$this->views->footer();
		$this->sidebar_data['links'][0]['selected'] = -1;
	}
	
	function create_announcement_submit(){
		$user = $this->session->userdata(USER);
		$announcement = $this->announcement_model->create_announcement($user['loginaccountid'],$this->input->post('title'),$this->input->post('content'));
		
		$orgs = $this->organization_model->get_organizations();
		$this->email_queue_model->queue_announcement_email($announcement['announcementid'],$orgs);
		
		redirect('osa/announcements');
	}
	
	function edit_announcement($announcementid)
	{
		$data['title'] = "Edit Announcement - OSA";	
		
		$fckeditorConfig = array(
			'instanceName' => 'content',
			'BasePath' => base_url().'system/plugins/fckeditor/',
			'ToolbarSet' => 'Basic',
			'Width' => '100%',
			'Height' => '400',
			'Value' => ''
			);
		
		$content_data['announcement'] = $this->Announcement_model->get_announcement($announcementid);
		$content_data['title'] = 'Edit Announcement';
		$content_data['submit_url'] = 'osa/edit_announcement_submit';
		
		$this->load->library('fckeditor', $fckeditorConfig);
		
		$this->sidebar_data['links'][0]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/create_announcement',$content_data);
		$this->views->footer();
		$this->sidebar_data['links'][0]['selected'] = -1;
	}
	
	function edit_announcement_submit()
	{
		$this->announcement_model->edit_announcement(
			$this->input->post('announcementid'),
			$this->input->post('title'),
			$this->input->post('content'));
		redirect('osa/announcements');
	}
	
	function delete_announcement($announcementid)
	{
		$this->announcement_model->delete_announcement($announcementid);
		redirect('osa/announcements');
	}
	
	function create_organization()
	{
		//$data['stylesheets'] = array('announcement.css');
		$data['title'] = "Add New Organization - OSA";	
		$content_data['submit_url'] = 'osa/create_organization_submit';
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/create_organization', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function create_organization_submit(){
		$this->form_validation->set_rules('username', 'Username', 'required|callback__orgusername_check');
		
		$this->form_validation->set_message('_orgusername_check', 'Username already exists, please use another.');
		
		if(!$this->form_validation->run()){
			$this->session->save_validation_errors();
			redirect('osa/create_organization');
		}
		
		$orgname = $this->input->post('orgname');
		$username = $this->input->post('username');
		$org_data = $this->Osa_model->create_organization($orgname, $username);
		$password = $org_data['password'];
		$orgid = $org_data['organizationid'];
		
		$this->Osa_model->create_organization_profile($orgid,$this->Variable->current_application_aysem());
		
		$this->_new_password("Successfully Added New Organization", $username, $password);
	}
	
	function _orgusername_check($username){
		return($this->Osa_model->is_unique_orgusername($username));
	}
	
	function _new_password($title, $username, $password){
		$data['title'] = $title;
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/create_organization_success', compact('title', 'username', 'password'));
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function reset_org_password($username = NULL){
		if(is_null($username))
			redirect('osa/organizations');
		
		$password = $this->Osa_model->reset_organization_password($username);
		
		$this->_new_password("New Password", $username, $password);
	}
	
	function announcements($page_no = 0,$announcement_id = -1)
	{
		$this->views->load_announcements($page_no,$announcement_id);
	}
	
	function organizations($page_no = 1){
		$data['stylesheets'] = array('organizations_list.css');
		$data['title'] = "Organizations - OSA";
		
		$limit = 20;
		
		$orgs = $this->organization_model->get_organizations();
		for($i=0;$i<count($orgs);$i++){
			$orgs[$i]['profile'] = $this->organization_model->get_organization_profile(
				$orgs[$i]['organizationid'],
				$this->Variable->current_application_aysem()
			);
			if($orgs[$i]['profile']){
			    if($orgs[$i]['profile']['orgstatusid']){
				    $orgs[$i]['profile']['orgstatusdesc'] = $this->organization_model->get_orgstatus($orgs[$i]['profile']['orgstatusid']);
			    }
			
			    if($orgs[$i]['profile']['orgcategoryid']){
				    $orgs[$i]['profile']['orgcategorydesc'] = $this->organization_model->get_orgcategory($orgs[$i]['profile']['orgcategoryid']);
			    }
			
			    $progress = $this->orgregistration_model->progress_array($orgs[$i]['organizationid'],$this->Variable->current_application_aysem());
			    $orgs[$i]['progress'] = $progress['form1']+
				    $progress['form1_advisers']+
				    $progress['form2']+
				    ($progress['form3_members']&&$progress['form3_officers'])+
				    $progress['form5_eventreports']+
				    $progress['form6']+
				    $progress['form7']+
				    $progress['reqs']+
				    ($orgs[$i]['profile']['orgstatusid']>APP_NOT_SUBMITTED)+
				    ($orgs[$i]['profile']['orgstatusid']==APP_RENEWED);
				
			    $orgs[$i]['progress']*=10;
			}
		}
		
		$content_data['orgs'] = $orgs;
		$content_data['aysem'] = $this->Variable->current_application_aysem();
		$content_data['span'] = 19;
		$content_data['site_link'] = 'osa/organizations/';
		$content_data['forward_link'] = 'osa/view_application/';
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('organizations/manage', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	//=============MANAGE REQUIREMENTS MODULE=============
	
	function manage_reqs($appsemid = CURRENT_APPSEM){
		$data['title'] = "Manage Requirements - OSA";
		
		$content_data['appsemid'] = $appsemid;
		$content_data['pretty_application_aysem'] = $this->Variable->pretty_application_aysem($appsemid);
		$content_data['appsems'] = result_to_option_array($this->Variable->get_valid_appsems_pretty(), 'appsemid', 'pretty');
		$content_data['reqs'] = $this->Osa_model->requirements_appsem($appsemid);
		
		$this->sidebar_data['links'][1]['selected'] = 1;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/manage_reqs', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function manage_reqs_change_appsem(){
		redirect("osa/manage_reqs/{$this->input->post('appsem')}");
	}
	
	function add_req($appsemid = NULL){
		if(is_null($appsemid))
			redirect('osa/manage_reqs');
		
		$data['title'] = "Add a Requirement - OSA";
		
		$content_data['appsemid'] = $appsemid;
		$content_data['pretty_application_aysem'] = $this->Variable->pretty_application_aysem($appsemid);
		$content_data['action'] = ACTION_ADD_REQ;
		$content_data['submit_url'] = "osa/add_req_submit/{$appsemid}";
		$content_data['postback'] = $this->session->postback_variable();
		$content_data['name'] = '';
		$content_data['description'] = '';
		
		$this->sidebar_data['links'][1]['selected'] = 1;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/req_form', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function add_req_submit($appsemid = NULL){
		if(is_null($appsemid))
			redirect('osa/manage_reqs');
			
		$postback['name'] = $this->input->post('name');
		$postback['description'] = $this->input->post('description');
			
		if($this->_validate_req_form(ACTION_ADD_REQ)){
			$this->Osa_model->add_req($appsemid, $postback['name'], $postback['description']);
			
			redirect("osa/manage_reqs/{$appsemid}");
		}
		else{
			$this->session->save_validation_errors();
			$this->session->save_postback_variable($postback);
			redirect("osa/add_req/{$appsemid}");
		}
	}
	
	function edit_req($requirementid = NULL){
		if(is_null($requirementid))
			redirect('osa/manage_reqs');
			
		$data['title'] = "Edit a Requirement - OSA";
		
		$requirement = $this->Osa_model->get_requirement($requirementid);

		$content_data['appsemid'] = $requirement['appsemid'];
		$content_data['name'] = $requirement['name'];
		$content_data['description'] = $requirement['description'];
		$content_data['pretty_application_aysem'] = $this->Variable->pretty_application_aysem($requirement['appsemid']);
		$content_data['action'] = ACTION_EDIT_REQ;
		$content_data['submit_url'] = "osa/edit_req_submit/{$requirement['requirementid']}";
		$content_data['postback'] = $this->session->postback_variable();
		
		$this->sidebar_data['links'][1]['selected'] = 1;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/req_form', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function edit_req_submit($requirementid = NULL){
		if(is_null($requirementid))
			redirect('osa/manage_reqs');
			
		$validated = $this->_validate_req_form(ACTION_EDIT_REQ);
		
		$requirement = $this->Osa_model->get_requirement($requirementid);
		$name = $this->input->post('name');
		
		$name_changed = $requirement['name'] !== $name;
		
		if($name_changed && !$this->_req_name_unique_check($name)){
			$this->session->add_validation_error("Requirement '{$name}' already exists");
			$validated = FALSE;
		}
			
		if($validated){
			$description = $this->input->post('description');
			
			$this->Osa_model->edit_req($requirementid, $name_changed?$name:NULL, $description);
			
			redirect("osa/manage_reqs/{$requirement['appsemid']}");
		}
		else{
			$postback['name'] = $this->input->post('name');
			$postback['description'] = $this->input->post('description');
			
			$this->session->save_validation_errors();
			$this->session->save_postback_variable($postback);
			redirect("osa/edit_req/{$requirementid}");
		}
	}
	
	function _validate_req_form($action){
		if($action === ACTION_ADD_REQ)
			$this->form_validation->set_rules('name', 'Name', 'required|callback__req_name_length_check|callback__req_name_unique_check');
		else if($action === ACTION_EDIT_REQ)
			$this->form_validation->set_rules('name', 'Name', 'required|callback__req_name_length_check');
			
		$this->form_validation->set_rules('description', 'Description', 'callback__req_description_check');
		
		return($this->form_validation->run());
	}
	
	function _req_name_length_check($name){
		if(strlen($name) > REQ_NAME_MAXLENGTH){
			$this->form_validation->set_message('_req_name_length_check', '%s is too long');
			return(FALSE);
		}
		
		return(TRUE);
	}
	
	function _req_name_unique_check($name){
		if(!$this->Osa_model->is_unique_req_name($name, $this->input->post('appsemid'))){
			$this->form_validation->set_message('_req_name_unique_check', "Requirement '{$name}' already exists");
			return(FALSE);
		}
		
		return(TRUE);
	}
	
	function _req_description_check($description){
		if(strlen($description) > REQ_DESC_MAXLENGTH){
			$this->form_validation->set_message('_req_description_check', '%s is too long');
			return(FALSE);
		}
		
		return(TRUE);
	}
	
	//=============MANAGE ORGANIZATION REQUIREMENTS MODULE=============
	
	function org_reqs($organizationid = NULL, $appsemid = CURRENT_APPSEM){
		if(is_null($organizationid))
			redirect('osa/organizations');
		
		$data['title'] = "Requirements - OSA";
		
		$this->load->model('Orgrequirement_model');
		$this->load->model('organization_model');
		
		$content_data['org_reqs'] = $this->Orgrequirement_model->get_requirements_appsem($organizationid, $appsemid);
		$content_data['org'] = $this->organization_model->get_organization($organizationid,$appsemid);
		$content_data['appsemid'] = $appsemid;
		$content_data['pretty_application_aysem'] = $this->Variable->pretty_application_aysem($appsemid);
		$content_data['appsems'] = result_to_option_array($this->Variable->get_valid_appsems_pretty(), 'appsemid', 'pretty');
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);
		$this->load->view('organization/requirements', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function org_reqs_change_appsem($organizationid){
		redirect("osa/org_reqs/{$organizationid}/{$this->input->post('appsem')}");
	}
	
	function manage_org_req($organizationid = NULL, $requirementid = NULL){
		if(is_null($organizationid) || is_null($requirementid))
			redirect('osa/organizations');
		
		$data['title'] = "View/Edit Organization Requirement Details - OSA";
		
		$this->load->model('Orgrequirement_model');
		$this->load->model('organization_model');
		
		$org_req = $this->Orgrequirement_model->get_requirement($organizationid, $requirementid);
		
		$content_data['org_req'] = $org_req;
		$content_data['org'] = $this->organization_model->get_organization($organizationid,$org_req['appsemid']);
		$content_data['pretty_application_aysem'] = $this->Variable->pretty_application_aysem($org_req['appsemid']);
		$content_data['appsems'] = result_to_option_array($this->Variable->get_valid_appsems_pretty(), 'appsemid', 'pretty');
		$content_data['submit_url'] = "osa/manage_org_req_submit/{$organizationid}/{$requirementid}";
		$content_data['editable'] = TRUE;
		$content_data['postback'] = $this->session->postback_variable();
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);
		$this->load->view('organization/req_details', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function manage_org_req_submit($organizationid = NULL, $requirementid = NULL){
		if(is_null($organizationid) || is_null($requirementid))
			redirect('osa/organizations');
		
		$postback['submitted'] = $this->input->post('submitted');
		$postback['submittedon'] = $this->input->post('submittedon');
		$postback['comments'] = $this->input->post('comments');
		
		if($this->_validate_org_req_form()){
			$this->load->model('Orgrequirement_model');
			
			$this->Orgrequirement_model->update_requirement($organizationid, $requirementid, $postback['submitted'], $postback['submittedon'], $postback['comments']);
			
			$requirement = $this->Osa_model->get_requirement($requirementid);
			
			redirect("osa/org_reqs/{$organizationid}/{$requirement['appsemid']}");
		}
		else{
			$this->session->save_validation_errors();
			$this->session->save_postback_variable($postback);
			redirect("osa/manage_org_req/{$organizationid}/{$requirementid}");
		}
	}
	
	function _validate_org_req_form(){
		if($this->input->post('submitted')){
			$this->form_validation->set_rules('submittedon', 'Date Submitted', 'required|callback__valid_date_check');
			$this->form_validation->set_rules('comments', 'Comments', 'callback__org_req_comment_check');
			
			return($this->form_validation->run());
		}
		else{
			return(TRUE);
		}
	}
	
	function _valid_date_check($date){
		$this->load->helper('date');
		
		$this->form_validation->set_message('_valid_date_check', 'Invalid date for %s');
		
		return(is_valid_date_format($date));
	}
	
	function _org_req_comment_check($comments){
		if(strlen($comments) > ORG_REQ_COMMENT_MAXLENGTH){
			$this->form_validation->set_message('_org_req_comment_check', '%s are too long');
			return(FALSE);
		}
		
		return(TRUE);
	}
	
	//=============MANAGE APPLICATION PERIOD MODULE=============
	
	function manage_app_period(){
		$this->load->helper('date');
		
		$data['title'] = "Manage Application Period - OSA";
		
		$content_data['submit_url'] = 'osa/manage_app_period_submit';
		$content_data['app_is_open'] = $this->Variable->app_is_open();
		$content_data['current_application_aysem'] = $this->Variable->current_application_aysem();
		$content_data['pretty_current_application_aysem'] = $this->Variable->pretty_current_application_aysem();
		$content_data['current_acadyear'] = $this->Variable->current_acadyear()?:mdate('%Y');
		$content_data['current_sem'] = $this->Variable->current_sem();
		
		$this->sidebar_data['links'][2]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/manage_app_period', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][2]['selected'] = -1;
	}
	
	function manage_app_period_submit(){
		if($this->input->post('submit') == 'Submit'){
			$this->form_validation->set_rules('acadyear', 'Academic Year', 'required|callback__acadyear_check');
			$this->form_validation->set_rules('sem', 'Semester', 'required|callback__sem_check');
			
			$this->form_validation->set_message('_aysem_check', "Illegal aysem format: '{$this->input->post('aysem')}'");
			
			if($this->form_validation->run()){
				$aysem = $this->input->post('acadyear').$this->input->post('sem');
				$is_new = $this->Variable->set_current_aysem($aysem);
				if($is_new){
					$this->Osa_model->create_organization_profiles($aysem);
				}
			}
		}
		else{
			$matches = array();
			preg_match('/^(Open|Close) Application$/', $this->input->post('submit'), $matches);
			
			$this->Variable->set_app_open_state($matches[1] === 'Open');
		}
		
		redirect('osa/manage_app_period');
	}
	
	function _acadyear_check($acadyear){
		return(preg_match('/^\d+$/', $acadyear) != 0);
	}
	
	function _sem_check($sem){
		return(in_array($sem, array(1, 2 ,3)));
	}
	
	function view_application($orgid,$aysem)
	{
		$org = $this->organization_model->get_organization($orgid,$aysem);		
		
		$data['title'] = "View Application - OSA";
		$data['span'] = 19;
		$content_data['org'] = $org;
		$content_data['appsemid'] = $aysem;
		$content_data['clarifications'] = $this->organization_model->get_clarifications($orgid, $aysem);
		$content_data['appsems'] = result_to_option_array($this->Variable->get_valid_appsems_pretty(), 'appsemid', 'pretty');
		$content_data['statuses'] = result_to_option_array($this->organization_model->get_orgstatuses(), 'orgstatusid', 'description');
		$content_data['progress'] = $this->orgregistration_model->progress_array($orgid,$aysem);
		$content_data['progress_total'] = 
			$content_data['progress']['form1']+
			$content_data['progress']['form1_advisers']+
			$content_data['progress']['form2']+
			($content_data['progress']['form3_members']&&$content_data['progress']['form3_officers'])+
			$content_data['progress']['form5_eventreports']+
			$content_data['progress']['form6']+
			$content_data['progress']['form7']+
			$content_data['progress']['reqs']+
			($content_data['org']['orgstatusid']>APP_NOT_SUBMITTED)+
			($content_data['org']['orgstatusid']==APP_RENEWED);
		$content_data['forms_suffix'] = "/{$aysem}/{$orgid}";			
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('organization/forms/index', $content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function change_application_status(){
		$organizationid = $this->input->post('orgid');
		$appsemid = $this->input->post('appsemid');
		$this->organization_model->save_organization_profile($organizationid,$appsemid,array('orgstatusid'=>$this->input->post('orgstatus')));
		redirect("osa/view_application/{$organizationid}/{$appsemid}");
	}
	
	function form_change_appsem_submit(){
		redirect("osa/view_application/{$this->input->post('orgid')}/{$this->input->post('appsem')}");
	}
	
	function create_clarification($orgid,$aysem){
		$data['title'] = "Create Message - OSA";	
		
		$fckeditorConfig = array(
			'instanceName' => 'description',
			'BasePath' => base_url().'system/plugins/fckeditor/',
			'ToolbarSet' => 'Basic',
			'Width' => '100%',
			'Height' => '400',
			'Value' => ''
			);
		$content_data['title'] = "Create Message";	
		$content_data['clarification']['description'] = '';
		$content_data['back_url'] = "osa/view_application/{$orgid}/{$aysem}";
		$content_data['submit_url'] = "osa/create_clarification_submit/{$orgid}/{$aysem}";
		
		$this->load->library('fckeditor', $fckeditorConfig);
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/create_clarification',$content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function create_clarification_submit($orgid,$aysem){
		$this->load->model('email_queue_model');
		
		$clarification = $this->organization_model->create_clarification($orgid,$aysem,$this->input->post('description'));
		$this->email_queue_model->queue_osa_to_organization_email($clarification['orgclarificationid'],$orgid);
		
		redirect("osa/view_application/{$orgid}/{$aysem}");
	}
	
	function edit_clarification($orgid,$aysem,$clarificationid){
		$data['title'] = "Create Message - OSA";	
		
		$fckeditorConfig = array(
			'instanceName' => 'description',
			'BasePath' => base_url().'system/plugins/fckeditor/',
			'ToolbarSet' => 'Basic',
			'Width' => '100%',
			'Height' => '400',
			'Value' => ''
			);
		$content_data['title'] = "Create Message";	
		$content_data['clarification'] = $this->organization_model->get_clarification($clarificationid);
		$content_data['back_url'] = "osa/view_application/{$orgid}/{$aysem}";
		$content_data['submit_url'] = "osa/edit_clarification_submit/{$orgid}/{$aysem}";
		
		$this->load->library('fckeditor', $fckeditorConfig);
		
		$this->sidebar_data['links'][1]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);		
		$this->load->view('osa/create_clarification',$content_data);
		$this->views->footer();
		$this->sidebar_data['links'][1]['selected'] = -1;
	}
	
	function edit_clarification_submit($orgid,$aysem){
		$this->load->model('email_queue_model');
		
		$clarification = $this->organization_model->edit_clarification($this->input->post('orgclarificationid'),$this->input->post('description'));
		$this->email_queue_model->queue_osa_to_organization_email($clarification['orgclarificationid'],$orgid);
		
		redirect("osa/view_application/{$orgid}/{$aysem}");
	}
	
	function delete_clarification($id,$orgid,$aysem){
		$this->organization_model->delete_clarification($id);
		$this->view_application($orgid,$aysem);
	}
	
	function change_password()
	{
		$data['title'] = "Change Password  - ".$this->session->username();
		$data['span'] = 19;
		$data['stylesheets'] = array('login.css');

		$this->sidebar_data['links'][3]['selected'] = 0;
		$this->views->header($data,$this->sidebar_data);
		$this->load->view('organization/change_password',$data);
		$this->views->footer();
		$this->sidebar_data['links'][3]['selected'] = -1;
	}

	function change_password_submit()
	{
		$this->form_validation->set_rules('old_pass', '"Current Password"', 'required|callback__password_check');
		$this->form_validation->set_message('_password_check', "The %s field doesn't match the current password of your account.");
		$this->form_validation->set_rules('new_pass_1', '"New Password"', 'required');
		$this->form_validation->set_rules('new_pass_2', '"New Password Confirmation"', 'required|matches[new_pass_1]');

		if (!$this->form_validation->run())
		{
			$this->change_password();
		}else{
			$this->load->model('osa_model');
			$this->osa_model->change_organization_password($this->session->username(),$this->input->post('new_pass_1'));

			$data['title'] = "Change Password  - ".$this->session->username();
			$data['span'] = 19;
			$data['stylesheets'] = array('login.css');

			$this->sidebar_data['links'][3]['selected'] = 0;
			$this->views->header($data,$this->sidebar_data);
			$this->load->view('organization/change_password_success',$data);
			$this->views->footer();
			$this->sidebar_data['links'][3]['selected'] = -1;
		}
	}

	//function send_to_all_orgs($subject, $message){
	//	$this->load->library('Emailer');
	//	
	//	$aysem = $this->Variable->current_application_aysem();
	//	$query = $this->organization_model->get_organization_profiles($aysem);
	//	foreach ($query as $row)
	//	{
	//		$this->Emailer->send_email($row['heademail'],$subject,$message);
	//	}
	//}
	
	//function send_to_org($orgid, $subject, $message){
	//	$aysem = $this->Variable->current_application_aysem();
	//	$query = $this->organization_model->get_organization_profile($orgid, $aysem);
	//	$this->Emailer->send_email($query['heademail'],$subject,$message);
	//}
	
}

/* End of file osa.php */
/* Location: ./application/controllers/osa.php */
