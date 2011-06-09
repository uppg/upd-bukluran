<?php
class Main extends Controller {
	function Main()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$params['announcement']['title'] = "Announcements";
		$params['announcement']['span'] = 24;
		$params['announcement']['site_link'] = 'main/announcements/';
		$params['announcement']['forward_link'] = 'main/announcements/';
		$params['announcement']['back_link'] = 'main/announcements/';
		
		$this->load->library('views',$params);
		$this->load->model('Organization_model');
		$this->load->model('Variable');
		
		$this->load->helper('cookie');
		// set_cookie('cookie_test','value','86500');
	}
	
	function index()
	{
		if($this->session->logged_in()){
			$userdata = $this->session->userdata(USER);
			redirect($userdata['groupname'].'/announcements');
		}
		redirect('main/announcements');
	} 
	
	function announcements($page_no = 0,$announcement_id = -1)
	{
		if($this->session->logged_in()){
			$userdata = $this->session->userdata(USER);
			redirect($userdata['groupname'].'/announcements');
		}
		$this->views->load_announcements($page_no,$announcement_id);
	}
	
	function organizations($page_no = 0,$org_id = -1)
	{
		if($this->session->logged_in()){
			$userdata = $this->session->userdata(USER);
			if(!$this->session->user_group_is(ORG_GROUPID))
				redirect($userdata['groupname'].'/organizations');
		}
		
		$limit=20;
	
		$data['stylesheets'] = array('organizations_list.css');
		$data['title'] = "Organizations";
		
		$this->views->header($data);
		if($org_id == -1){
			$data['orgs']=$this->Organization_model->get_organizations();
			$data['span']=24;
			$data['site_link']='main/organizations/';
			$data['forward_link']='main/organizations/0/';
			
			$this->load->view('organizations/list', $data);
		}else{
			$data['org']=$this->Organization_model->get_organization($org_id,$this->Variable->current_application_aysem());
			$data['span']=24;
			$data['back_link']='main/organizations/';
			
			$this->load->view('organizations/public_profile',$data);
		}
		$this->views->footer();		
	}
	
	function contact()
	{
		$data['title'] = 'Contact Us';
		$this->views->header($data);
		$this->load->view('contact');
		$this->views->footer();
	}
//MISC

	function pdf()
	{
		$this->load->plugin('dompdf');
		$html = $this->load->view('contact', null, true);
		pdf_create($html, 'filename');
	}

	function fckeditorform()
	{
		$fckeditorConfig = array(
			'instanceName' => 'content',
			'BasePath' => base_url().'system/plugins/fckeditor/',
			'ToolbarSet' => 'Basic',
			'Width' => '100%',
			'Height' => '200',
			'Value' => ''
			);
		
		$this->load->library('fckeditor', $fckeditorConfig);
		$this->load->view('fckeditorView');
        
	}
	function fckeditorshowpost()
	{
        echo $this->input->post('content');
	}	
	
	function jquery()
	{
		$header_data['other'] = <<<TEXT
		
		<script type="text/javascript">
		$(function(){

			// Accordion
			$("#accordion").accordion({ header: "h3" });

			// Tabs
			$('#tabs').tabs();


			// Dialog			
			$('#dialog').dialog({
				autoOpen: false,
				width: 600,
				buttons: {
					"Ok": function() { 
						$(this).dialog("close"); 
					}, 
					"Cancel": function() { 
						$(this).dialog("close"); 
					} 
				}
			});
			
			// Dialog Link
			$('#dialog_link').click(function(){
				$('#dialog').dialog('open');
				return false;
			});

			// Datepicker
			$('#datepicker').datepicker({
				inline: true
			});
			
			// Slider
			$('#slider').slider({
				range: true,
				values: [17, 67]
			});
			
			// Progressbar
			$("#progressbar").progressbar({
				value: 20 
			});
			
			//hover states on the static widgets
			$('#dialog_link, ul#icons li').hover(
				function() { $(this).addClass('ui-state-hover'); }, 
				function() { $(this).removeClass('ui-state-hover'); }
			);
			
		});
	</script>
	<style type="text/css">
		/*demo page css*/
		body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
		.demoHeaders { margin-top: 2em; }
		#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
		#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
		ul#icons {margin: 0; padding: 0;}
		ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
		ul#icons span.ui-icon {float: left; margin: 0 4px;}
	</style>

TEXT;

		$this->views->header($header_data);
		$this->load->view('jqueryui-test');
		$this->views->footer();
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
