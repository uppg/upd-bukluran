<?php

class Award_model extends Model {
	function Awards_model() {
		parent::Model();
	}
	
	function get_awards($appsemid,$organizationid) {
		$this->db->where('appsemid', $appsemid);
		$this->db->where('organizationid', $organizationid);
		$this->db->orderby('awardclassificationid');
		$query = $this->db->get('orgawards');
		return ($query->result_array());		
	}
	
	function add_award($appsemid,$organizationid, $awarddetails) {
		$awarddetails['organizationid'] = $organizationid;
		$awarddetails['appsemid'] = $appsemid;
		$this->db->insert('orgawards', $awarddetails);
	}
	
	function update_award($appsemid,$organizationid, $orgawardid, $awarddetails) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'orgawardid' => $orgawardid);
		$this->db->where($params);
		$this->db->update('orgawards', $awarddetails);	
	}
	
	function remove_award($appsemid,$organizationid, $orgawardid) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'orgawardid' => $orgawardid);
		$this->db->where($params);
		$this->db->delete('orgawards');
	}
	
	function get_award($appsemid,$organizationid, $orgawardid) {
		$params = array('appsemid' => $appsemid,
						'organizationid' => $organizationid,
						'orgawardid' => $orgawardid);
		$this->db->where($params);
		$query = $this->db->get('orgawards');
		return ($query->first_row('array'));		
	}
	
	function get_awardclassifications() {
		$this->db->from('awardclassifications');
		$query = $this->db->get();
		return ($query->result_array());
	}
}

//end of awards_model.php