<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Form 7 - Acknowledgment
	</div>
	<?if($this->session->user_group_is(ORG_GROUPID) && !$this->Variable->app_is_open()):?>
	<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all notification">
		<span class="ui-icon ui-icon-info notification-icon"></span> 
		Registration is Currently Closed.
		<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span> 
	</div>
	</div>
	<?=br()?>
	<?endif;?>
		
	<p>
	Currently viewing form 3 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<? if($this->session->user_group_is(OSA_GROUPID) && count($appsems) > 1): ?>
	
	<?= form_open($change_appsem_submit_url) ?>
	View application form for different application period:
	<?= form_dropdown('appsem', $appsems, $appsemid) ?>
	<?= form_hidden('orgid',$organization['organizationid'])?>
	<?= form_submit('submit', 'Go') ?>
	<?= form_close(); ?>
	
	<? endif; ?>
	<?=form_open('organization/form7_submit'.($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":""))?>
	<h3>Name of Organization: <?=$orgname?></h3>
	<h4>We attest, upon our honor, that all statements in all the pages submitted for student organization registration are
true, correct and accurate.</h4>

	<div class="radio">
	<?=form_radio('acknowledged',1,set_value('acknowledged',$organization['acknowledged']=='t'),'id="acknowledged_yes"')?>
	<?=form_label('Yes','acknowledged_yes')?>
	<?=form_radio('acknowledged',0,!set_value('acknowledged',$organization['acknowledged']=='t'),'id="acknowledged_no"')?>
	<?=form_label('No','acknowledged_no')?>
	</div>
	
	<p class="notes">
		This form serves as a replacement for the signatures of the Head, the Finance Officer and the Faculty Adviser of the organization.
	</p>
	<p class="notes">
		By selecting Yes above, the organization attests that all the information submitted are correct and the organization is punishable by laws of the University if any falsification of documents occur.
	</p>
	<?=br(3).form_submit('submit','Save')?>
	<?=form_close()?>
</div>

<script>
	$('.radio').buttonset();
	$('#acknowledged_yes').css('position','absolute');	
	$('#acknowledged_no').css('position','absolute');
</script>

