<?php

class Announcement_model extends Model{

	public function __construct(){
		parent::__construct();
	}
	
	function get_announcement($announcementid){
		$this->db->from('announcements a');
		$this->db->join('loginaccounts l','a.loginaccountid = l.loginaccountid');
		$this->db->where('a.announcementid', $announcementid);
		
		$query = $this->db->get();
		return($query->row_array());
	}
	
	function get_announcements($limit = 20, $offset = 0){
		$this->db->from('announcements a');
		$this->db->join('loginaccounts l','a.loginaccountid = l.loginaccountid');
		$this->db->order_by('date_modified','desc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		return($query->result_array());
	}
	
	function count_announcements(){
		$this->db->from('announcements');
		return $this->db->count_all_results();
	}
	
	function create_announcement($loginaccountid, $title, $content){		
		$announcement['loginaccountid'] = $loginaccountid;
		$announcement['title'] = $title;
		$announcement['content'] = $content;
		$announcement['date_created'] = $announcement['date_modified'] = date('Y-m-d H:i:s');
		$this->db->insert('announcements',$announcement);
		
		$this->db->from('announcements');
		$this->db->where('date_created',$announcement['date_created']);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function edit_announcement($announcementid, $title, $content){		
		$announcement['title'] = $title;
		$announcement['content'] = $content;
		$announcement['date_modified'] = date('Y-m-d H:i:s');
		$this->db->where('announcementid',$announcementid);
		$this->db->update('announcements',$announcement);
	}
	
	function delete_announcement($announcementid){
		$this->db->delete('email_queue', array('announcementid' => $announcementid));
		$this->db->delete('announcements', array('announcementid' => $announcementid)); 
	}
}