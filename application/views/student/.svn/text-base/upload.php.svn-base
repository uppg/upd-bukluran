<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Upload UP ID - <?=$username?>
	</div>
	
	<?if(!$this->Variable->app_is_open()):?>
	<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all notification">
		<span class="ui-icon ui-icon-info notification-icon"></span> 
		Registration is Currently Closed.
		<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span> 
	</div>
	</div>
	<?=br()?>
	<?endif;?>
	
	<?if($message):?>
	<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all notification">
		<span class="ui-icon ui-icon-info notification-icon"></span> 
		<?=$message?>
		<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span> 
	</div>
	</div>
	<?endif;?>
	
	<?if(array_key_exists('filepath',$image)):?>
	Current Picture:<?=br(2)?>
	<?=img(array('src'=>'./uploads/'.$image['filepath'],'max-width'=>'100%'))?>
	<?endif;?>
	
	<?=form_open_multipart($submit_url,array('class'=>"form_large"));?>
	<?=form_upload('userfile','','class="text_input"');?>
	<?=form_submit('upload','Upload','class="submit_default" id="submit"');?>
	<?=form_close();?>
	
	<?if($this->session->user_group_is(ORG_GROUPID)):?>
		<?=anchor('organization/form3','Back')?>
	<?elseif($this->session->user_group_is(OSA_GROUPID)):?>
		<?=anchor("osa/view_application/{$organizationid}/{$appsemid}",'Back')?>
	<?else:?>
		<?=anchor('student','Back')?>
	<?endif;?>
	
</div>

<script type="text/javascript">
	$('.form_large #submit').removeClass('submit_default').button();
</script>