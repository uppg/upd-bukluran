<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Registration
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
	<? if($this->session->user_group_is(OSA_GROUPID) && count($appsems) > 1): ?>	
		<?= form_open('osa/form_change_appsem_submit') ?>
		Currently viewing regisration of organization <strong><?= $org['orgname'] ?></strong><br/>
		View registration for different application period:
		<?= form_dropdown('appsem', $appsems, $appsemid) ?>
		<?= form_hidden('orgid',$org['organizationid'])?>
		<?= form_submit('submit', 'Go') ?>
		<?= form_close(); ?>
	<? endif; ?>
	<div id="progress"></div>
	Progress: <?=round($progress_total*10,2)?>%<?=br(1)?>
	
	<?if($this->session->user_group_is(ORG_GROUPID)):?>
		Status: <?=$org['orgstatusdesc']?>
		<?=br(2)?>
	<?else:?>
		<?= form_open('osa/change_application_status') ?>
			<?= form_label('Status:','orgstatus')?>
			<?= form_dropdown('orgstatus', $statuses, $org['orgstatusid']) ?>
			<?= form_hidden('orgid',$org['organizationid'])?>
			<?= form_hidden('appsemid',$appsemid)?>
			<?= form_submit('submit', 'Change') ?>
		<?= form_close() ?>
	<?endif;?>	
	
	<div id="progress_list">
		<div title= "<?=($progress['form1'])?"OK":"Form1 Needs to be filled up"?>">
		<span id="progress_form1" class="ui-icon ui-icon-<?=($progress['form1'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form1{$forms_suffix}","Form 1 - Information Sheet");?><br />
		</div>
		
		<div title= "<?=($progress['form1_advisers'])?"OK":"You need at least one confirmed adviser"?>">
		<span id="progress_form1_advisers" class="ui-icon ui-icon-<?=($progress['form1_advisers'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form1_faculty_adviser{$forms_suffix}","Form 1 - Faculty Advisers");?><br />
		</div>
		
		<div title= "<?=($progress['form2'])?"OK":"You need to have an entry in the Starting Balance Field and the Collections and Disbursements Table"?>">
		<span id="progress_form2" class="ui-icon ui-icon-<?=($progress['form2'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form2{$forms_suffix}","Form 2 - Finance Statement");?><br />
		</div>
		
		<div title= "<?=($progress['form3_officers'])?(($progress['form3_members'])?"OK":"You need at least 15 confirmed members with their IDs uploaded"):(($progress['form3_members'])?"You need at least 5 confirmed officers with their IDs uploaded":"You need at least 5 confirmed officers and 15 confirmed members with their IDs uploaded")?>">
		<span id="progress_form3" class="ui-icon ui-icon-<?=($progress['form3_officers'] && $progress['form3_members'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form3{$forms_suffix}","Forms 3 and 4 - Officer and Member Roster");?><br />
		</div>
		
		<div title= "<?=($progress['form5_eventreports'])?(($progress['form5_awards'])?"OK":"There are no Awards [Not Required]"):"All event categories should have at least one event"?>">
		<span id="progress_form5" class="ui-icon ui-icon-<?=($progress['form5_eventreports'])?(($progress['form5_awards'])?"check":"alert"):"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form5{$forms_suffix}","Form 5 - Accomplishment Report");?><br />
		</div>
		
		<div title= "<?=($progress['form6'])?"OK":"All event categories should have at least one event"?>">
		<span id="progress['form6']" class="ui-icon ui-icon-<?=($progress['form6'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form6{$forms_suffix}","Form 6 - Calendar of Activities");?><br />
		</div>
		
		<div title= "<?=($progress['form7'])?"OK":"Acknowledgment needed"?>">
		<span id="progress['form7']" class="ui-icon ui-icon-<?=($progress['form7'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/form7{$forms_suffix}","Form 7 - Acknowledgment");?><br />
		</div>
		
		<div title= "<?=($progress['reqs'])?"OK":"Some requirements are not yet submitted"?>">
		<span id="progress['reqs']" class="ui-icon ui-icon-<?=($progress['reqs'])?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor($this->session->user_group_is(OSA_GROUPID)?"osa/org_reqs/{$org['organizationid']}":"organization/requirements","Requirements");?><br />
		</div>
		
		<div title= "<?=$org['orgstatusdesc']?>">
		<span id="progress['reqs']" class="ui-icon ui-icon-<?=($org['orgstatusid']>APP_NOT_SUBMITTED)?"check":"closethick"?> progress-check-icon"></span>
		<?=anchor("organization/submit_forms{$forms_suffix}","Submit to OSA");?><br />
		</div>
		
		<p class="notes">
			<strong>Note:</strong> Clicking on "Submit to OSA" will make the forms final and uneditable. Make sure all of the forms are filled up correctly before clicking on "Submit to OSA".
		</p><br /><br />
	</div>
	
	<div class="contentHeader_text">
		Messages from OSA
	</div>
	
	<? if($this->session->user_group_is(OSA_GROUPID)):?>
		<?=anchor('osa/create_clarification/'.$org['organizationid'].'/'.$appsemid,'Add Message').br(2)?>
	<? endif;?>
	
	<? if(count($clarifications)):?>
	<table class="tablesorter">
	<thead>
		<tr>
			<th>Date Sent</th>
			<th>Message</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($clarifications as $clarification): ?>
		<tr>
			<td><?= $clarification['date_created'] ?></td>
			<td><?= $clarification['description'] ?></td>
			<td>
				<?= anchor('organization/view_clarification/'.$clarification['orgclarificationid'],'View') ?> 
				<? if($this->session->user_group_is(OSA_GROUPID)): ?>
					<?= anchor("osa/edit_clarification/{$org['organizationid']}/{$appsemid}/{$clarification['orgclarificationid']}",'Edit')?>
					<?= anchor("osa/delete_clarification/{$clarification['orgclarificationid']}/{$org['organizationid']}/{$appsemid}",'Delete')?>					
				<? endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
	</table>
	<div id="pagination">
		<?=form_open()?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/first.png",'class'=>"first"))?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/prev.png",'class'=>"prev"))?>
			<?=form_input(array('class'=>'pagedisplay'))?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/next.png",'class'=>"next"))?> 
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/last.png",'class'=>"last"))?> 
			<?=form_dropdown('pagesize',array(
				10=>10,
				20=>20,
				30=>30,
				40=>40
			),'10','class="pagesize"')?>
		<?=form_close()?>
		Search: <input name="filter" id="filter-box" value="" maxlength="30" size="30" type="text"> <input id="filter-clear-button" type="submit" value="Clear"/>
	</div>
	<? if($this->session->user_group_is(OSA_GROUPID)):?>
		<?=br(2).anchor('osa/create_clarification/'.$org['organizationid'].'/'.$appsemid,'Add Message')?>
	<? endif;?>
	<? else:?>
		No Messages From OSA
	<? endif;?>
	<script>
		var progress = <?=$progress_total*10?>;
		$('#progress').progressbar({value:0});
		$('#progress .ui-progressbar-value').delay(300).animate({width:progress+"%"},3000,"easeOutBounce",function(){$('#progress').progressbar({value:progress});});
	</script>
	
</div>

