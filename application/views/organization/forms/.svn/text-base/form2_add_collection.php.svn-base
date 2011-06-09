<div class="span-19 last" id="content_main">
	<? 
		$this->load->helper('inflector');
	?>

	<div class="contentHeader_text">
		Form 2 - Add Collection Entry
	</div>
	
	<?if($this->session->user_group_is(ORG_GROUPID) && !$this->Variable->app_is_open()):?>
		Registration is Currently Closed.
	<?else:?>
	
	<p><?= $this->session->validation_errors() ?></p>
	
	<p>
	Currently adding entry to Collections of form 2 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<?= form_open('organization/form2_add_collection_submit'.($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":'')) ?>
	<table>
	<tr>
		<td><?= form_label('Detail', 'description') ?></td>
		<td><?= form_input('description') ?></td>
	</tr>
	<tr>
		<td><?= form_label('Amount', 'amount') ?></td>
		<td><?= form_input('amount') ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?= form_submit('submit', "Save") ?></td>
	</tr>
	</table>
	<?= form_close() ?>
	<?endif;?>
</div>
