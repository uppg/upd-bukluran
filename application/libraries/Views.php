<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Views {

	function Views($params=FALSE)
	{	
		$this->CI =& get_instance();
		if($params){
			$keys = array('sidebar','announcement','organization');
			foreach($keys as $key){
				if(array_key_exists($key,$params)){
					$this->data[$key] = $params[$key];
				}
			}
		}
		$this->CI->load->model('Student_model');
		$this->CI->load->model('Faculty_model');
		$this->CI->load->model('Announcement_model');
		$this->aysem = $this->CI->Variable->current_application_aysem();
	}
	
	function load_organizations($page_no = 0, $messages = FALSE)
	{
		$this->data['stylesheets'] = array('organizations_list.css');
		$this->data['title'] = $this->data['organization']['title'];
		
		$limit = 20;
		$user = $this->CI->session->userdata(USER);
		if($this->CI->session->user_group_is(STUDENT_GROUPID)){
			$orgs = $this->CI->Student_model->get_organizations($user['studentid'], $this->aysem, $limit, ($page_no - 1) * $limit);
			if(!$this->CI->Student_model->has_studentpicture($user['studentid'], $this->aysem)){
				if(!$messages)$messages = array();
				$messages[] = "You haven't uploaded an image of your School ID yet. ".anchor('student/upload','Click here')." to upload."; 
			}
		}else if($this->CI->session->user_group_is(FACULTY_GROUPID)){
			$orgs = $this->CI->Faculty_model->get_organizations($user['facultyid'], $this->aysem, $limit, ($page_no - 1) * $limit);
			if(!$this->CI->Faculty_model->has_profile($user['facultyid'])){
				if(!$messages)$messages = array();
				$messages[] = "Your profile is not yet set. ".anchor('faculty/edit_profile','Click here')." to create your profile."; 
			}
		}
		
		$this->data['organization']['orgs'] = $orgs;
		$this->data['organization']['messages'] = $messages;
		
		$this->data['sidebar']['links'][1]['selected']=0;
		
		$this->header($this->data,$this->data['sidebar']);
		$this->CI->load->view('organizations/confirm_list', $this->data['organization']);
		$this->footer();
		
		$this->data['organization']['message'] = FALSE;
		$this->data['sidebar'][1]['selected']=-1;
	}
	
	function header($data=FALSE,$sidebar=FALSE)
	{
		$this->CI->load->view('htmlhead',$data);
		$this->CI->load->view('header');
		$this->CI->load->view('layout/content/header');
		$this->CI->load->view('layout/content/div_open');
		if($sidebar)$this->CI->load->view('sidebar/links_only',$sidebar);
	}
	
	function footer()
	{
		$this->CI->load->view('layout/content/div_close');
		$this->CI->load->view('layout/content/footer');
		$this->CI->load->view('footer');
	}

    function load_announcements($offset = 0, $announcement_id = -1)
    {	
		$limit = 5;
		
		$this->data['title'] = $this->data['announcement']['title'];
		$this->data['stylesheets'] = array('announcement.css');
		$this->data['announcement']['page_no'] = $offset;
		
		
		if(array_key_exists('sidebar',$this->data)){
			$this->data['sidebar']['links'][0]['selected']=0;
			$this->header($this->data,$this->data['sidebar']);
			$this->data['sidebar']['links'][0]['selected']=-1;
		}else{
			$this->header($this->data);
		}
		if($announcement_id == -1){
			$this->data['announcement']['announcements'] = $this->CI->Announcement_model->get_announcements($limit, $offset);
			$this->data['announcement']['total'] = $this->CI->Announcement_model->count_announcements();
			$this->data['announcement']['limit'] = $limit;
			$this->CI->load->view('announcements/list', $this->data['announcement']);
		}else{
			$this->data['announcement']['announcement'] = $this->CI->Announcement_model->get_announcement($announcement_id);
			$this->CI->load->view('announcements/announcement', $this->data['announcement']);
		}
		
		$this->footer();
		
		
    }
}

?>