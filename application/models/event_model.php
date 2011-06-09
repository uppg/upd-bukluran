<?php

class Event_model extends Model {

	public function __construct() {
		parent::Model();
	}

	function get_eventcategories() {
		$this->db->from('eventcategories');
		$query = $this->db->get();
		return ($query->result_array());
	}

	function get_plannedevents($appsemid,$organizationid,$eventcategoryid) {
		$this->db->where(array('appsemid' => $appsemid, 'organizationid' => $organizationid, 'eventcategoryid' => $eventcategoryid));
		$this->db->order_by('eventdate asc');
		$query = $this->db->get('plannedevents');
		return ($query->result_array());
	}

	function add_plannedevent($appsemid,$organizationid,$eventdetails) {
		$eventdetails['organizationid'] = $organizationid;
		$eventdetails['appsemid'] = $appsemid;
		$this->db->insert('plannedevents',$eventdetails);
	}
	
	function update_plannedevent($appsemid, $organizationid, $plannedeventid, $eventdetails) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'plannedeventid' => $plannedeventid);
		$this->db->where($params);
		$this->db->update('plannedevents', $eventdetails);		
	}
	
	function remove_plannedevent($appsemid,$organizationid,$plannedeventid) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'plannedeventid' => $plannedeventid);
		$this->db->where($params);
		$this->db->delete('plannedevents');
	}
	
	function get_plannedevent($appsemid, $organizationid, $plannedeventid) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'plannedeventid' => $plannedeventid);
		$this->db->where($params);
		$query = $this->db->get('plannedevents');
		return ($query->first_row('array'));
	}

	function get_eventreports($appsemid,$organizationid, $eventcategoryid) {
		$this->db->where(array('appsemid' => $appsemid, 'organizationid' => $organizationid,'eventcategoryid' => $eventcategoryid));
		$this->db->order_by('eventdate asc');
		$query = $this->db->get('eventreports');
		return ($query->result_array());
	}

	function add_eventreport($appsemid,$organizationid,$eventdetails) {
		$eventdetails['organizationid'] = $organizationid;
		$eventdetails['appsemid'] = $appsemid;
		$this->db->insert('eventreports',$eventdetails);
	}

	function update_eventreport($appsemid, $organizationid, $eventreportid, $eventdetails) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'eventreportid' => $eventreportid);
		$this->db->where($params);
		$this->db->update('eventreports', $eventdetails);		
	}	
	
	function remove_eventreport($appsemid,$organizationid,$eventreportid) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'eventreportid' => $eventreportid);
		$this->db->where($params);
		$this->db->delete('eventreports');
	}
	
	function get_eventreport($appsemid,$organizationid,$eventreportid) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'eventreportid' => $eventreportid);
		$this->db->where($params);
		$query = $this->db->get('eventreports');		
		return ($query->first_row('array'));
	}
	
}