<?php

class PG_Session extends CI_Session{
	
	function __construct(){
		parent::__construct();
	}
	
	function logged_in(){
		return($this->userdata(USER) !== FALSE);
	}
	
	function user_group_is($groupid){
		if(!$this->logged_in())
			return(FALSE);
		
		$user = $this->userdata(USER);
		return($user['groupid'] == $groupid);
	}
	
	function username(){
		if($this->userdata(USER)){
			$user = $this->userdata(USER);
			return($user['username']);
		}
		else
			return('guest');
	}
	
	function loginaccountid(){
		if($this->userdata(USER)){
			$user = $this->userdata(USER);
			return($user['loginaccountid']);
		}
		else
			return(NULL);
	}
	
	function organizationid(){
		if($this->userdata(USER) && $this->user_group_is(ORG_GROUPID)){
			$user = $this->userdata(USER);
			return($user['organizationid']);
		}
		else
			return(NULL);
	}
	
	function orgname(){
		if($this->userdata(USER) && $this->user_group_is(ORG_GROUPID)){
			$user = $this->userdata(USER);
			return($user['orgname']);
		}
		else
			return(NULL);
	}
	
	function save_postback_variable($postback){
		$this->set_userdata(POSTBACKVAR, $postback);
	}
	
	function postback_variable(){
		$postback = $this->userdata(POSTBACKVAR);
		
		$this->unset_userdata(POSTBACKVAR);
		
		return($postback);
	}
	
	function save_validation_errors(){
		$this->set_userdata(VALERR, $this->userdata(VALERR).validation_errors());
	}
	
	function add_validation_error($error){
		$this->set_userdata(VALERR, $this->userdata(VALERR).'<div class="ui-widget"><div class="ui-state-error ui-corner-all notification" title="Login Error"><span class="ui-icon ui-icon-alert notification-icon"></span>'.$error.'<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span></div></div>');
	}
	
	function validation_errors(){
		if($this->userdata(VALERR)){
			$validation_errors = $this->userdata(VALERR);
			$this->unset_userdata(VALERR);
			
			return($validation_errors);
		}
		else
			return(validation_errors());
	}
	
	function has_validation_errors(){
		return($this->userdata(VALERR) !== FALSE);
	}
}
