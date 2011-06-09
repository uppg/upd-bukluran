<?php

class Orgform2_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function get_collections($orgid,$appsemid)
	{
		$this->db->from('orgcollections');
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$appsemid);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_disbursements($orgid,$appsemid)
	{
		$this->db->from('orgdisbursements');
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$appsemid);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function insert_collection($orgid,$appsemid,$amount,$description){
		$this->db->set('organizationid',$orgid);
		$this->db->set('appsemid',$appsemid);
		$this->db->set('amount',$amount);
		$this->db->set('description',$description);
		$this->db->insert('orgcollections');
	}
	
	function insert_disbursement($orgid,$appsemid,$amount,$description){
		$this->db->set('organizationid',$orgid);
		$this->db->set('appsemid',$appsemid);
		$this->db->set('amount',$amount);
		$this->db->set('description',$description);
		$this->db->insert('orgdisbursements');
	}
	
	function delete_collection($id)
	{
		$this->db->where('orgcollectionid',$id);
		$this->db->delete('orgcollections');
	}
	
	function delete_disbursement($id)
	{
		$this->db->where('orgdisbursementid',$id);
		$this->db->delete('orgdisbursements');
	}
	
	function collection_belongs($id,$orgid)
	{
		$this->db->from('orgcollections');
		$this->db->where('orgcollectionid',$id);
		$this->db->where('organizationid',$orgid);
		return ($this->db->count_all_results() > 0);
	}
	
	function disbursement_belongs($id,$orgid)
	{
		$this->db->from('orgdisbursements');
		$this->db->where('orgdisbursementid',$id);
		$this->db->where('organizationid',$orgid);
		return ($this->db->count_all_results() > 0);
	}
	
	function update_collection($id,$description,$amount)
	{
		$this->db->where('orgcollectionid',$id);
		$this->db->set('description',$description);
		$this->db->set('amount',$amount);
	
		$this->db->update('orgcollections');
	}
	
	function update_disbursement($id,$description,$amount)
	{
		$this->db->where('orgdisbursementid',$id);
		$this->db->set('description',$description);
		$this->db->set('amount',$amount);
	
		$this->db->update('orgdisbursements');
	}
	
	function update_starting_balance($orgid,$appsemid,$balance){
		$this->db->where('organizationid',$orgid);
		$this->db->where('appsemid',$appsemid);
		$this->db->set('startingbalance',$balance);
		$this->db->update('orgprofiles');
	}
}

