<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Add New Organization
	</div>
<?= $this->session->validation_errors() ?>
<?php $this->load->helper('form');?>
<?= form_open($submit_url); ?>
<?= form_label('Organization Name:', 'orgname'); ?>
<?= form_input('orgname', set_value('orgname')); ?>
<?= form_label('Username:','username'); ?>
<?= form_input('username', set_value('username')); ?>
<?= form_submit('submit','Submit'); ?>
<?= form_close(); ?>
</div>
