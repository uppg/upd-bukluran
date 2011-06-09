<? $this->fckeditor->Value = htmlspecialchars_decode(set_value('description',$organization['orgdescription']))?>

<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Form 1 - Information Sheet
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
	Currently viewing form 1 of organization <strong><?= $organization['orgname'] ?></strong><br/>
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
	
	<?= validation_errors() ?>
	<?=form_open("organization/form1_submit/{$appsemid}/{$organization['organizationid']}")?>
	<table>
		<tr>
			<td><?=form_label('Official Name of the Organization:','name')?></td>
			<td><?=form_input('name',$organization['orgname'],$this->session->user_group_is(OSA_GROUPID)?'':'disabled="true"')?></td>
		</tr>
		<tr>
			<td><?=form_label('Acronym or Other Names:','acronym')?></td>
			<td><?=form_input('acronym',set_value('acronym',$organization['acronym']))?></td>
		</tr>
		<tr>
			<td><?=form_label('Date Established (yyyy-mm-dd):','date_established')?></td>
			<td><?=form_input('date_established',set_value('date_established',$organization['establisheddate']),'class="datepicker"')?></td>
		</tr>
		<tr>
			<td><?=form_label('Category:','category')?></td>
			<td><?=form_dropdown('category',$categories,set_value('category',$organization['orgcategoryid']))?></td>
		</tr>
		<tr>
			<td><?=form_label('Is your organization incorporated with the<br/>Securities & Exchange Commission?','sec_incorporated')?></td>
			<td>
				<div class="radio">
				<?=form_radio('sec_incorporated',1,set_value('sec_incorporated',$organization['secincorporated']=='t'),'id="sec_incorporated_yes"')?>
				<?=form_label('Yes','sec_incorporated_yes')?>
				<?=form_radio('sec_incorporated',0,!set_value('sec_incorporated',$organization['secincorporated']=='t'),'id="sec_incorporated_no"')?>
				<?=form_label('No','sec_incorporated_no')?>
				</div>
			</td>
		</tr>
		<tr id="incorporated">
			<td><?=form_label('Date Incorporated (yyyy-mm-dd):','date_incorporated')?></td>
			<td><?=form_input('date_incorporated',set_value('date_incorporated',$organization['incorporationdate']),'class="datepicker"')?></td>
		</tr>
		<tr>
			<td><?=form_label('Mailing Address:','mailaddr')?></td>
			<td><?=form_textarea('mailaddr',set_value('mailaddr',$organization['mailaddr']))?></td>
		</tr>
		<tr>
			<td><?=form_label("Permanent Email Address:",'orgemail')?></td>
			<td><?=form_input('orgemail',set_value('orgemail',$organization['orgemail']))?></td>
		</tr>
		<tr>
			<td><?=form_label("Head's Email Address:",'heademail')?></td>
			<td><?=form_input('heademail',set_value('heademail',$organization['heademail']))?></td>
		</tr>
		
		<tr>
			<td><?=form_label("Description:",'description')?></td>
			<td><?=$this->fckeditor->Create();?></td>
		</tr>
		<tr>
			<td></td>
			<td><?=form_submit('submit','Save')?></td>
		</tr>
	</table>
	<?=form_close()?>
</div>

<script>
	$('.datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		minDate: '1908-06-01',
		maxDate: 0
	});
	$('.radio').buttonset();
	if($('#sec_incorporated_no').attr('checked')){
		$('#incorporated').hide();
	}
	$('#sec_incorporated_yes').click(function(){
		$('#incorporated').fadeIn('slow');
	})
	.css('position','absolute');	
	$('#sec_incorporated_no').click(function(){
		$('#incorporated').fadeOut('slow');
		$('#incorporated :input').attr('value','');
	})
	.css('position','absolute');
</script>