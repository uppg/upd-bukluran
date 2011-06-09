<?php 
	$this->load->helper('html');
	$this->load->helper('url');
	$this->load->helper('form');
	$this->load->library('pagination');
?>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7"> <!--meta data to force IE8 to render in IE8 Mode. Otherwise it will render in IE6 mode-->
	<title><?php if(isset($title)) echo $title.' - '; ?>Bukluran 2.0</title>

	<?= link_tag('layout/images/favicon.png','shortcut icon','image/ico')."\n";?>
	
<!-- Blueprint CSS Framework http://www.blueprintcss.org/ -->
	<?= link_tag('layout/css/blueprint/screen.css','stylesheet','text/css','','screen, projection')."\n";?>
	<?= link_tag('layout/css/blueprint/print.css','stylesheet','text/css','','print')."\n";?>
	<!--[if lt IE 8]><?= link_tag('layout/css/blueprint/ie.css','stylesheet','text/css','','screen, projection');?><![endif]-->
<!-- /Blueprint CSS Framework -->   
 
<!-- JQuery -->
	<!-- jQuery Core -->
	<script src="<?= base_url().'layout/js/jquery-1.4.2.min.js' ?>" type="text/javascript"></script>
	<!-- jQuery UI -->
	<script src="<?= base_url().'layout/js/jquery-ui-1.8.custom.min.js' ?>" type="text/javascript"></script>
	<!-- jQuery UI Blitzer Theme -->
	<?= link_tag('layout/css/blitzer/jquery-ui-1.8.custom.css','stylesheet','text/css','','screen')."\n";?>
<!-- /JQuery -->

<!-- sliding login panel http://web-kreation.com/demos/Sliding_login_panel_jquery/ -->
	<!-- stylesheets -->
	<?= link_tag('layout/css/loginpanel/style.css','stylesheet','text/css','','screen')."\n";?>
	<?= link_tag('layout/css/loginpanel/slide.css','stylesheet','text/css','','screen')."\n";?>
  	<!-- PNG FIX for IE6 http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script src="<?= base_url().'layout/js/loginpanel/pngfix/supersleight-min.js';?>" type="text/javascript"></script>
	<![endif]-->
	<!-- Sliding effect -->
	<script src="<?= base_url().'layout/js/loginpanel/slide.js';?>" type="text/javascript"></script>
<!--/sliding login panel -->
	
<!-- jQuery Tablesorter 2.0 Plug-in http://tablesorter.com -->
	<script src="<?= base_url().'layout/js/jquery.tablesorter.min.js' ?>" type="text/javascript"></script>
	<script src="<?= base_url().'layout/js/jquery.tablesorter.pager.js' ?>" type="text/javascript"></script>
	<script src="<?= base_url().'layout/js/jquery.tablesorter.filter.js' ?>" type="text/javascript"></script>
	<!--http://www.compulsivoco.com/2008/08/tablesorter-filter-results-based-on-search-string/-->
	<?= link_tag('layout/css/bluesorter/style.css','stylesheet','text/css','','screen')."\n";?>
	<?= link_tag('layout/css/jquery.tablesorter.pager.css','stylesheet','text/css','','screen')."\n";?>
<!-- /jQuery Tablesorter 2.0 Plug-in -->

<!-- jReject Script http://jreject.turnwheel.com/ -->
	<script src="<?= base_url().'layout/js/jReject/jquery.reject.js';?>" type="text/javascript"></script>
	<script type="text/javascript">
	window.onload=function(){$.reject({
	/*
	reject: {
		safari: true, // Apple Safari
		chrome: true, // Google Chrome
		firefox: true, // Mozilla Firefox
		msie: true, // Microsoft Internet Explorer
		opera: true, // Opera
		konqueror: true, // Konqueror (Linux)
		unknown: true // Everything else
	},
	*/
	imagePath: '<?= base_url().'layout/images/browsers/';?>',
	afterReject: function(){$('div#toppanel').hide();},
	afterClose: function(){$('div#toppanel').fadeIn();},
	});return false;}
	</script>
<!--/jReject Script -->

	<?= link_tag('layout/css/print.css','stylesheet','text/css','','print')."\n";?>
	<?= link_tag('layout/css/style.css','stylesheet','text/css','','screen, projection')."\n";?>

<!--page specific stylesheets-->
	<?php if(isset($stylesheets)):?>
		<?php foreach ($stylesheets as $stylesheet):?>
			<?= link_tag('layout/css/'.$stylesheet,'stylesheet','text/css','','screen, projection')."\n";?>
		<?php endforeach;?>
	<?php endif;?>
<!--/ page specific stylesheets-->

	<script src="<?= base_url().'layout/js/startup.js';?>" type="text/javascript"></script>
	<script type="text/javascript">
		var base_url = "<?=base_url()?>"
		var site_url = "<?=site_url()?>"
	</script>

<!--Other Head Data -->
	<?php if(isset($other)) echo $other;?>
<!--/Other Head Data -->
</head>
