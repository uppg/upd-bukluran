<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Form 5
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
	Currently viewing form 5 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<? if($this->session->user_group_is(OSA_GROUPID) && count($appsems) > 1): ?>
	
	<?= form_open($change_appsem_submit_url) ?>
	View application form for different application period:
	<?= form_dropdown('appsem', $appsems, $appsemid) ?>
	<?= form_hidden('orgid',$orgid)?>
	<?= form_submit('submit', 'Go') ?>
	<?= form_close(); ?>
	<? endif; ?>
	
	<!--insert actual form here-->
	<?php 

	echo heading('Accomplishment Report',2);

	//report of activities
	echo heading('Activities',2);
	echo anchor($add_event_url, 'Add An Event');
	echo br(2);
	foreach($eventcategories as $eventcategory) {
		echo heading($eventcategory['description'],3);
		if (count($eventcategory['eventrecords']) > 0) {
			$this->table->set_heading('TITLE OF ACTIVITY','BRIEF DESCRIPTION OF ACTIVITY','VENUE','DATE','ACTION');
			foreach ($eventcategory['eventrecords'] as $event) {
				$edit_url = $edit_event_url."{$event['eventreportid']}";
				$remove_url = $remove_event_url."{$event['eventreportid']}";
				$this->table->add_row($event['eventname'],$event['description'],$event['venue'],date("F j, Y",strtotime($event['eventdate'])),anchor($edit_url,'Edit').' '.anchor($remove_url,'Delete'));
			}
			echo $this->table->generate();
			$this->table->clear();
		}
		else {
			echo nbs(5).'<p>There are no events listed</p>';
		}
		echo '<hr>';
	}

	//awards
	echo heading('Awards/Citations Received');
	echo anchor($add_award_url, 'Add An Award');
	echo br(2);
	if (count($orgawards) > 0) {
		$this->table->set_heading('AWARD CLASSIFICATION','AWARD/CITATION','DESCRIPTION','AWARD-GIVING BODY','ACTION');
		foreach($orgawards as $award) {
			$edit_url = $edit_award_url."{$award['orgawardid']}";
			$remove_url = $remove_award_url."{$award['orgawardid']}";
			$this->table->add_row($awardclassifications[$award['awardclassificationid']],$award['awardname'],$award['description'],$award['giver'],anchor($edit_url,'Edit').' '.anchor($remove_url,'Delete'));
		}
		echo $this->table->generate();
		$this->table->clear();
	} else {
		echo nbs(5).'<p>There are no awards listed.</p>';
	}
	echo '<hr>';
	?>
</div>

