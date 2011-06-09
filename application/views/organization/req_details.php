<script src="<?= base_url().'layout/js/organization/req_details.js' ?>" type="text/javascript" ></script>

<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Organization Requirements
	</div>

	<p><?= $this->session->validation_errors() ?></p>

	<p>
	Viewing requirement of organization <strong><?= $org['orgname'] ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<?= form_open($submit_url) ?>
	<table>
	<tr>
		<td>Name:</td>
		<td><strong><?= $org_req['name'] ?></strong></td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><?= $org_req['description'] ?></td>
	</tr>
	<tr>
		<td>Submitted Status:</td>
		<td>
			<? if($editable): ?>
				<?
				$submittedvalue = NULL;
				if($postback)
					$submittedvalue = $postback['submitted'];
				else
					$submittedvalue = $org_req['submittedon']?1:0;
				?>
				<?= form_dropdown('submitted', array(0 => 'Not Yet Submitted', 1 => 'Submitted'), $submittedvalue, 'id="submitted"') ?>
			<? else: ?>
				<input type="hidden" name="submitted" id="submitted" value="<?= $org_req['submittedon']?1:0 ?>" />
				<strong><?= $org_req['submittedon']?'Submitted':'Not Yet Submitted' ?></strong>
			<? endif; ?>
		</td>
	</tr>
	<tr>
		<td><div class="submitteddetails">Date Submitted:</div></td>
		<td><div class="submitteddetails"><?= form_input('submittedon', $postback['submittedon']?:$org_req['submittedon'], ($editable?'':'disabled ').'id="submittedon"') ?></div></td>
	</tr>
	<tr>
		<td><div class="submitteddetails">Comments:</div></td>
		<td><div class="submitteddetails"><?= form_textarea('comments', $postback['comments']?:$org_req['comments'], $editable?'':'disabled') ?></div></td>
	</tr>
	<? if($editable): ?>
	<tr>
		<td></td>
		<td><?= form_submit('submit', 'Update Organization Requirement') ?></td>
	</tr>
	<? else: ?>
	
	<? endif; ?>
	</table>
	<?= form_close() ?>
	
		<? if($editable): ?>
		<?= anchor("osa/org_reqs/{$org['organizationid']}/{$org_req['appsemid']}", 'Back to Organization Requirements') ?>
	<? else: ?>
		<?= anchor("organization/requirements", 'Back to Organization Requirements') ?>
	<? endif; ?>
</div>
