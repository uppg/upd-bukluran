<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Change Password Success!
	</div>
	
	<?= anchor(($this->session->user_group_is(OSA_GROUPID)?'osa':'organization'),'Back to Main Page')?>
	
</div>
