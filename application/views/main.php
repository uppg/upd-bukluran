<?php 
	$this->load->helper('html');
	$this->load->helper('url');
?>

<html>
<head>
	<title>Bukluran 2.0</title>
	<link  href="images/favicon.png" rel="shortcut icon" type="image/ico" />
	<?= link_tag('layout/css/blueprint/screen.css');?>
	<?= link_tag('layout/css/blueprint/print.css');?>
	<?= link_tag('layout/css/style.css');?>
<!--
	<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection">
-->
	<!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->


<!--sliding login panel-->
	<!-- stylesheets -->
	<?= link_tag('layout/css/loginpanel/style.css');?>
	<?= link_tag('layout/css/loginpanel/slide.css');?>
<!--	
  	<link rel="stylesheet" href="css/loginpanel/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/loginpanel/slide.css" type="text/css" media="screen" />
-->	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/loginpanel/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- jQuery - the core -->
	<script src="<?= base_url().'layout/js/loginpanel/jquery-1.3.2.min.js';?>" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="<?= base_url().'layout/js/loginpanel/slide.js';?>" type="text/javascript"></script>
<!--sliding login panel-->
</head>
<body>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>Welcome to Bukluran</h1>
				<p class="grey">Online registration system for organizations of University of the Philippines Diliman</p>
			</div>
			<div class="left">
				<h3>For Students:</h3>
				<p class="grey">use your UP Webmail account for logging in</p>
				<h3>For Organizations:</h3>
				<p class="grey">use the account details provided by OSA</p>
			</div>
			<div class="left right">
				<!-- Login Form -->
				<form class="clearfix" action="#" method="post">
					<h1>Login</h1>
					<label class="grey" for="log">Username:</label>
					<input class="field" type="text" name="log" id="log" value="" size="23" />
					<label class="grey" for="pwd">Password:</label>
					<input class="field" type="password" name="pwd" id="pwd" size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<a class="lost-pwd" href="#">Lost your password?</a>
				</form>
			</div>
			
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Hello Guest!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Log In</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> 
<!--panel -->

<div id="header">
<div class="container">
<div class="span-24 last">
<?= img('layout/images/header.png');?>
</div>
<!--
<div class="clear prepend-14 span-12 last header-footer-text">
</br></br>
online registration system for student organizations of UP Diliman
</div>
-->
</div>
</div>

<div id="content">
<div class="container">
	<div class="span-24 last">
		<H2>Announcements</H2>
	</div>
</div>
</div>

<div id="footer">
<div class="container">
<div class="span-24 last">
<?= img('layout/images/footer.png');?>
</div>
<!--
<div class="span-24 last header-footer-text">
<center>2009 &copy; UP Programming Guild</center>
</div>
-->
</div>
</div>

</body>
</html>
