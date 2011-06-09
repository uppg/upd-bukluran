<?php

class Orgregistration_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function form1($organizationid, $appsemid){
		$org = $this->get_profile($organizationid, $appsemid);
		
		return $org['acronym'] && $org['establisheddate'] &&
			$org['orgcategoryid'] && 
			(($org['secincorporated'] == 't' && $org['incorporationdate']) || 
			$org['secincorporated'] == 'f') &&
			$org['mailaddr'] && $org['orgemail'] &&
			$org['heademail'] && $org['orgdescription'];
	}
	
	function form1_advisers($organizationid, $appsemid){
		$this->db->from('orgadvisers');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$no_advisers = $this->db->count_all_results();
		
		$this->db->from('orgadvisers');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$this->db->where('confirmed','true');
		$no_confirmed = $this->db->count_all_results();
		
		return  $no_advisers > 0 && $no_confirmed > 0;
	}
	
	function form2($organizationid, $appsemid){
		if($this->is_new_profile($organizationid,$appsemid)){
			return true;
		}
		$org = $this->get_profile($organizationid, $appsemid);
		
		$this->db->from('orgcollections');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$collections = $this->db->count_all_results();
		
		$this->db->from('orgdisbursements');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$disbursements = $this->db->count_all_results();
		
		return $collections > 0 && $disbursements;
	}
	
	function form3_members($organizationid, $appsemid){		
		$this->db->from('orgmemberships m');
		$this->db->join('studentpictures p','p.studentid=m.studentid');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('m.appsemid',$appsemid);
		$this->db->where('confirmed','true');
		$this->db->where('position', NULL);
		
		return $this->db->count_all_results() >= 15;
	}
	
	function form3_officers($organizationid, $appsemid){		
		$this->db->from('orgmemberships m');
		$this->db->join('studentpictures p','p.studentid=m.studentid');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('m.appsemid',$appsemid);
		$this->db->where('confirmed','true');
		$this->db->where('position IS NOT NULL', NULL, FALSE);
		
		return $this->db->count_all_results() >= 5;
	}
	
	function form5_eventreports($organizationid, $appsemid){
		if($this->is_new_profile($organizationid,$appsemid)){
			return true;
		}
		
		$categories = $this->get_eventcategories();
		
		$this->db->from('eventreports');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$reports = $this->db->get();
		$reports = $reports->result_array();
		
		foreach($reports as $report){
			if(count($categories) == 0)
				return true;
			unset($categories[$report['eventcategoryid']]);
		}
		
		return count($categories) == 0;
	}
	
	function form5_awards($organizationid, $appsemid){
		if($this->is_new_profile($organizationid,$appsemid)){
			return true;
		}
		
		$this->db->from('orgawards');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		
		return $this->db->count_all_results() > 0;
	}
	
	function form6($organizationid, $appsemid){
		$categories = $this->get_eventcategories();
		
		$this->db->from('plannedevents');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$events = $this->db->get();
		$events = $events->result_array();
		
		foreach($events as $event){
			if(count($categories) == 0)
				return true;
			unset($categories[$event['eventcategoryid']]);
		}
		
		return count($categories) == 0;
	}
	
	function form7($organizationid, $appsemid){
		$org = $this->get_profile($organizationid, $appsemid);
		
		return $org['acknowledged'] == 't';
	}
	
	function requirements($organizationid, $appsemid){
		//select * from requirements r where requirementid not in (select requirementid from orgsubmittedrequirements where organizationid = 1) and appsemid = 20093;
		$this->db->from('requirements r');
		$this->db->where('requirementid not in',"(select requirementid from orgsubmittedrequirements where organizationid = {$organizationid} and appsemid = {$appsemid})",false);
		$this->db->where('appsemid',$appsemid);
		
		return $this->db->count_all_results() == 0;
	}
	
	function is_ok($organizationid, $appsemid){
		$progress_form1 = $this->form1($organizationid,$appsemid);
		$progress_form1_advisers = $this->form1_advisers($organizationid,$appsemid);
		$progress_form2 = $this->form2($organizationid,$appsemid);
		$progress_form3_members = $this->form3_members($organizationid,$appsemid);
		$progress_form3_officers = $this->form3_officers($organizationid,$appsemid);
		$progress_form5_eventreports = $this->form5_eventreports($organizationid,$appsemid);
		$progress_form5_awards = $this->form5_awards($organizationid,$appsemid);
		$progress_form6 = $this->form6($organizationid,$appsemid);
		$progress_form7 = $this->form7($organizationid,$appsemid);
		$progress_reqs = $this->requirements($organizationid,$appsemid);
		$progress_total = $progress_form1+$progress_form1_advisers+$progress_form2+($progress_form3_members&&$progress_form3_officers)+$progress_form5_eventreports+$progress_form6+$progress_form7;
		return $progress_total == 7;
	}
	
	function progress_array($organizationid,$appsemid){
		$progress['form1'] = $this->form1($organizationid,$appsemid);
		$progress['form1_advisers'] = $this->form1_advisers($organizationid,$appsemid);
		$progress['form2'] = $this->form2($organizationid,$appsemid);
		$progress['form3_members'] = $this->form3_members($organizationid,$appsemid);
		$progress['form3_officers'] = $this->form3_officers($organizationid,$appsemid);
		$progress['form5_eventreports'] = $this->form5_eventreports($organizationid,$appsemid);
		$progress['form5_awards'] = $this->form5_awards($organizationid,$appsemid);
		$progress['form6'] = $this->form6($organizationid,$appsemid);
		$progress['form7'] = $this->form7($organizationid,$appsemid);
		$progress['reqs'] = $this->requirements($organizationid,$appsemid);
		
		return $progress;
	}
	
	function progress_total($organizationid,$appsemid){
		$progress = $this->progress_array($organizationid,$appsemid);
		$profile = $this->get_profile($organizationid,$appsemid);
		
		return $progress['form1']+
			$progress['form1_advisers']+
			$progress['form2']+
			($progress['form3_members']&&$progress['form3_officers'])+
			$progress['form5_eventreports']+
			$progress['form6']+
			$progress['form7']+
			$progress['reqs']+
			($profile['orgstatusid']>APP_NOT_SUBMITTED)+
			($profile['orgstatusid']==APP_RENEWED);
	}
	
	private function get_profile($organizationid, $appsemid){
		$this->db->from('orgprofiles');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	private function is_new_profile($organizationid,$appsemid){
		$this->db->from('orgprofiles');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid <=',$appsemid);
		return $this->db->count_all_results() == 1;
	}
	
	private function get_eventcategories(){
		$this->db->from('eventcategories');
		$query = $this->db->get();
		$rows = $query->result_array();
		
		foreach($rows as $row){
			$result[$row['eventcategoryid']] = $row['description'];
		}
		
		return $result;
	}
	
	private function total_members($organizationid,$appsemid){
		$this->db->from('orgmemberships');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$this->db->where('position', NULL);
		
		return $this->db->count_all_results();
	}
	
	private function total_officers($organizationid,$appsemid){
		$this->db->from('orgmemberships');
		$this->db->where('organizationid',$organizationid);
		$this->db->where('appsemid',$appsemid);
		$this->db->where('position IS NOT NULL', NULL, FALSE);
		
		return $this->db->count_all_results();
	}
}
