<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Manage Application Period
	</div>
	
	<p>
	<strong>Application Status: </strong>
	
	<? if(is_null($app_is_open)): ?>
		Undefined, assuming closed.
	<? else: ?>
		<?= $app_is_open?'Open':'Closed' ?>
	<? endif; ?>
	
	<br/>
	
	<strong>Application Period Academic Term: </strong>
	<? if(is_null($current_application_aysem)): ?>
		Undefined, please enter in the form below.
	<? else: ?>
		<?= $pretty_current_application_aysem ?>
	<? endif; ?>
	</p>
	
	<?= $this->session->validation_errors() ?>
	<?php $this->load->helper('form');?>
	<?= form_open($submit_url); ?>
	<h3>Change Application Status</h3>
	<?= form_submit('submit', ($app_is_open?'Close':'Open').' Application'); ?> <br/>
	<br/>
	<h3>Change Application Period</h3>
	<?= form_label('Academic year: ','acadyear'); ?>
	<?= form_input('acadyear', set_value('acadyear')?:$current_acadyear, 'size="5" maxlength="4"'); ?><br/>
	<?= form_label('Semester: ','sem'); ?>
	<?= form_dropdown('sem', array(1 => '1st Semester', 2 => '2nd Semester', 3 => 'Summer'), set_value('sem')?:$current_sem); ?><br/>
	<?= form_submit('submit','Submit'); ?>
	<?= form_close(); ?>
</div>

