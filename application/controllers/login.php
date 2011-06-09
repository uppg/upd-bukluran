<?php
class Login extends Controller {

	function Login()
	{
		parent::Controller();		
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('views');
		$this->load->model('lostcredentials_model');
		$this->load->model('osa_model');
		$this->load->model('email_queue_model');
		$this->load->model('organization_model');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all notification" title="Login Error"><span class="ui-icon ui-icon-alert notification-icon"></span>', '<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span></div></div>');
	}
	
	function index()
	{
		if($this->session->logged_in()){
			$userdata = $this->session->userdata(USER);
			redirect($userdata['groupname']);
		}
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback__authenticate_login');
		
		$this->form_validation->set_message('_authenticate_login', 'Invalid username/password combination.');
		// $this->form_validation->set_message('_cookies_enabled_check', 'Cookies should be enabled in your browser.');
		
		if(!$this->form_validation->run()){
			$this->page();
			return;
		}
		
		$userdata = $this->session->userdata(USER);
		redirect($userdata['groupname']);
		
		/*
		if($this->input->post('username') == 'osa')
			redirect('osa');
		elseif($this->input->post('username') == 'org')
			redirect('organization');
		else
			redirect('student');
		*/
	}
	
	function page()
	{
		$this->load->helper('cookie');
		set_cookie('cookie_test','value','86500');
		$data['stylesheets'] = array('login.css');
		$data['title'] = 'Login';
		$this->views->header($data);
		$this->load->view('login/user_pass');
		$this->views->footer();
	}
	
	function logout(){
		$this->session->unset_userdata(USER);
		redirect();
	}
	
	function _authenticate_login(){
		$this->load->model('Login_model');
		
		$user = $this->Login_model->authenticate_login($this->input->post('username'), $this->input->post('password'));
		
		if($user){
			unset($user['password']);
			$this->session->set_userdata(USER, $user);
			return(true);
		}
		else{
			$this->session->unset_userdata(USER);
			return(false);
		}
	}
	
	function link($link=""){
		$this->load->helper('cookie');
		set_cookie('cookie_test','value','86500');
		$data['stylesheets'] = array('login.css');
		$data['title'] = 'Login';
		$data['link'] = $link;
		$this->views->header($data);
		$this->load->view('login/link');
		$this->views->footer();
	}
	
	function link_submit(){
		$this->form_validation->set_rules('link', 'Link', 'required|callback__authenticate_link');
		
		$this->form_validation->set_message('_authenticate_link', 'Invalid code.');
		// $this->form_validation->set_message('_cookies_enabled_check', 'Cookies should be enabled in your browser.');
		
		if(!$this->form_validation->run()){
			$this->link();
			return;
		}
		$userdata = $this->session->userdata(USER);
		redirect($userdata['groupname']);
	}
	
	function _authenticate_link(){
		$this->load->model('Login_model');
		$user = $this->Login_model->authenticate_link($this->input->get_post('link'));
		if($user){
			unset($user['hashcode']);
			$this->session->set_userdata(USER, $user);
			return(true);
		}
		else{
			$this->session->unset_userdata(USER);
			return(false);
		}
	}
	
	function lost_link(){
		$data['stylesheets'] = array('login.css');
		$data['title'] = 'Lost Confirmation Code';
		$this->views->header($data);
		$this->load->view('login/lost_link');
		$this->views->footer();
	}
	
	function lost_link_submit(){
		$this->form_validation->set_rules('webmail', 'UP Webmail', 'required|valid_email|callback__valid_upwebmail|callback__webmail_exists');
		$this->form_validation->set_message('_valid_upwebmail', "The %s field is not a valid UP Webmail Address.");
		$this->form_validation->set_message('_webmail_exists', "The UP Webmail Address doesn't exist.");
		if(!$this->form_validation->run()){
			$this->lost_link();
		}else{
			$webmail = $this->input->post('webmail');
			$user = $this->lostcredentials_model->get_link($webmail);
			if(array_key_exists('facultyid',$user)){
				$this->email_queue_model->queue_lost_faculty_hashcode_email($user['facultyid']);
			}else{
				$this->email_queue_model->queue_lost_student_hashcode_email($user['studentid']);
			}
			$data['title'] = 'Lost Confirmation Code Retrieval Success';
			$this->views->header($data);
			$this->load->view('login/lost_success');
			$this->views->footer();
		}
	}
	
	function lost_pass(){
		$data['stylesheets'] = array('login.css');
		$data['title'] = 'Lost Password';
		$this->views->header($data);
		$this->load->view('login/lost_pass');
		$this->views->footer();
	}
	
	function lost_pass_submit(){
		$this->form_validation->set_rules('username', 'Username', 'required|callback__username_exists');
		$this->form_validation->set_message('_username_exists', "The %s doesn't exist.");		
		if(!$this->form_validation->run()){
			$this->lost_pass();
		}else{
			$username = $this->input->post('username');
			$orgid = $this->lostcredentials_model->get_organizationid($username);
			$this->email_queue_model->queue_lost_password_email($orgid);
			
			$data['title'] = 'Lost Password Retrieval Success';
			$this->views->header($data);
			$this->load->view('login/lost_success');
			$this->views->footer();
		}
	}
	
	function _username_exists($username){
		return $this->osa_model->orgusername_exists($username);
	}
	
	function _webmail_exists($webmail){
		return $this->lostcredentials_model->webmail_exists($webmail);
	}
	
	function _valid_upwebmail($string){
		$array = explode('@',$string);
		return $array[1]=='up.edu.ph';
	}
	/* 
	function _cookies_enabled_check(){
		$this->load->helper('cookie');
		set_cookie('cookie_test','value','86500');
		$var = get_cookie('cookie_test');
		delete_cookie('cookie_test');
		
		return $var='value';
	}
	*/
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
