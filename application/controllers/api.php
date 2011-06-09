<?php
class Api extends Controller{
	
	function Api()
	{
		parent::Controller();
		$this->load->model('api_model');
		$this->load->model('login_model');
		$this->load->model('variable');
		$this->load->model('organization_model');
	}
	
	function remote_login($apikey, $username, $password)
	{
		if($this->api_model->authenticate($apikey)){
			$login = $this->login_model->authenticate_login($username, $password, true);
			if($login == false){
				echo '{"authenticated":false}';
			}else{
				$organization = $this->organization_model->get_organization($login['organizationid'],$this->variable->current_application_aysem());
				
				echo '{"authenticated":true,'.
					 ' "organizationid":'.$organization['organizationid'].','.
					 ' "orgname":"'.$organization['orgname'].'",'.
					 ' "acronym":"'.$organization['acronym'].'"'.
					 '}';
			}
		}else{
			echo '{"authenticated":false}';
		}
	}
}