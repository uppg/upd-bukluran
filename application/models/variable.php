<?php

define('VARTAB', 'variables');
define('APPSEMTAB', 'appsems');
define('APP_IS_OPEN', 'appisopen');
define('CURRENT_APP_AYSEM', 'current_aysem');

class Variable extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	private function set($varname, $value){
		$this->db->set('value', $value);
		
		if($this->var_has_entry($varname)){
			$this->db->where('varname', $varname);
			$this->db->update(VARTAB);
		}
		else{
			$this->db->set('varname', $varname);
			$this->db->insert(VARTAB);
		}
	}
	
	private function get($varname){
		if(!$this->var_has_entry($varname))
			return(NULL);
		
		$this->db->select('value');
		$this->db->from(VARTAB);
		$this->db->where('varname', $varname);
		
		$query = $this->db->get();
		$result = $query->row_array();
		
		return($result['value']);
	}
	
	private function var_has_entry($varname){
		$this->db->where('varname', $varname);
		return($this->db->count_all_results(VARTAB) > 0);
	}
	
	function app_is_open(){
		$app_open_state = $this->get(APP_IS_OPEN);
		
		if(is_null($app_open_state))
			log_message('error', 'Illegal state: no APP_IS_OPEN variable entry in variables table');
		
		return($app_open_state);
	}
	
	function set_app_open_state($openness){
		if(!is_bool($openness))
			throw new Exception("Illegal argument type: {$openness}");
		
		$this->set(APP_IS_OPEN, $openness);
	}
	
	function current_application_aysem(){
		$current_app_aysem = $this->get(CURRENT_APP_AYSEM);
		
		if(is_null($current_app_aysem))
			log_message('error', 'Illegal state: no CURRENT_APP_AYSEM variable entry in variables table');
		
		return($current_app_aysem);
	}
	
	function pretty_application_aysem($aysem){
		$sem = $this->sem_from_aysem($aysem);
		$acadyear = $this->acadyear_from_aysem($aysem);
		
		$pretty_sem = $this->pretty_sem($sem);
		$pretty_acadyear = $this->pretty_acadyear($acadyear);
		
		$pretty_app_aysem = "{$pretty_sem} {$pretty_acadyear}";
		return($pretty_app_aysem);
	}
	
	function pretty_current_application_aysem(){
		return($this->pretty_application_aysem($this->current_application_aysem()));
	}
	
	private function sem_from_aysem($aysem){
		return(substr($aysem, 4, 1));
	}
	
	private function acadyear_from_aysem($aysem){
		return(substr($aysem, 0, 4));
	}
	
	function current_sem(){
		$current_app_aysem = $this->current_application_aysem();
		
		$sem = $this->sem_from_aysem($current_app_aysem);
		
		return($sem);
	}
	
	private function pretty_sem($sem){
		$pretty_sem = NULL;
		switch($sem){
			case 1:
				$pretty_sem = '1st Semester';
				break;
			case 2:
				$pretty_sem = '2nd Semester';
				break;
			case 3:
				$pretty_sem = 'Summer';
				break;
			default:
				log_message('error', 'Illegal value for sem passed');
		}
		
		return($pretty_sem);
	}
	
	function pretty_current_sem(){
		return($this->pretty_sem($this->current_sem()));
	}
	
	function current_acadyear(){
		$current_app_aysem = $this->current_application_aysem();
		
		$acadyear = $this->acadyear_from_aysem($current_app_aysem);
		
		return($acadyear);
	}
	
	private function pretty_acadyear($acadyear){
		return("academic year {$acadyear}");
	}
	
	function pretty_current_acadyear(){		
		return($this->pretty_acadyear($this->current_acadyear()));
	}
	
	function set_current_aysem($aysem){
		$return = false;
		
		if(!$this->is_legal_aysem_format($aysem))
			throw new UnexpectedValueException("Illegal aysem format: '{$aysem}'");
		
		if(!$this->is_legal_aysem_value($aysem)){
			// throw new UnexpectedValueException("Illegal aysem value: '{$aysem}' No such aysem in appsems table");
			$this->create_appsem($aysem);
			$return = true;
		}
		
		$this->set(CURRENT_APP_AYSEM, $aysem);
		return $return;
	}
	
	function get_valid_appsems(){
		$this->db->select('appsemid');
		$this->db->from(APPSEMTAB);
		$this->db->order_by('appsemid');
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function get_valid_appsems_pretty(){
		$valid_appsems = $this->get_valid_appsems();
		
		for($i = 0; $i < count($valid_appsems); $i++){
			$appsemid = $valid_appsems[$i]['appsemid'];
			
			$valid_appsems[$i]['pretty'] = $this->pretty_application_aysem($appsemid);
		}
		
		return($valid_appsems);
	}
	
	private function is_legal_aysem_format($aysem){
		return(preg_match('/^\d+[123]$/', $aysem));
	}
	
	private function is_legal_aysem_value($aysem){
		$this->db->from(APPSEMTAB);
		$this->db->where('appsemid', $aysem);
		
		return($this->db->count_all_results() > 0);
	}
	
	function create_appsem($appsem){
		$this->db->set('appsemid',$appsem);
		$this->db->set('insertedby',$this->session->loginaccountid());
		$this->db->insert('appsems');
	}
}
