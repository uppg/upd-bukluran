<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Organization Requirements
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
	Managing requirements for <strong><?= $org['orgname'] ?></strong> for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<? if($this->session->user_group_is(OSA_GROUPID) && count($appsems) > 1): ?>
	
	<?= form_open("osa/org_reqs_change_appsem/{$org['organizationid']}") ?>
	Manage requirements for different application period:
	<?= form_dropdown('appsem', $appsems, $appsemid) ?>
	<?= form_submit('submit', 'Go') ?>
	<?= form_close(); ?>
	
	<? endif; ?>
	
	<? if(count($org_reqs) > 0): ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th>Submitted</th>
			<th>Requirement</th>
			<th>Date Submitted</th>
			<th>Has Comments?</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		<? foreach($org_reqs as $org_req): ?>
		<tr>
			<td><?= $org_req['submittedon']?'Yes':'No' ?></td>
			<td><?= $org_req['name'] ?></td>
			<td><?= $org_req['submittedon'] ?></td>
			<td><?= $org_req['comments']?'Yes':'No' ?></td>
			<td>
				<?
					$actionurl = NULL;
					$actiontext = NULL;
					if($this->session->user_group_is(OSA_GROUPID)){
						$actionurl = "osa/manage_org_req/{$org['organizationid']}/{$org_req['requirementid']}";
						$actiontext = 'View/Update details';
					}
					else{
						$actionurl = "organization/view_req/{$org_req['requirementid']}";
						$actiontext = 'View details';
					}
				?>
				<?= anchor($actionurl, $actiontext) ?>
			</td>
		</tr>
		<? endforeach; ?>
		</tbody>
	</table>
	<? else: ?>
	There are currently no requirements that organizations need to submit for this application period.<br/>
	<?if($this->session->user_group_is(OSA_GROUPID)):?>
	You may add requirements using the <?= anchor('osa/manage_reqs', 'Manage Requirements') ?> module.
	<?endif;?>
	<? endif; ?>
	<?if($this->session->user_group_is(OSA_GROUPID)):?>
	<?= anchor("osa/organizations", 'Back to Organization List') ?>
	<? endif; ?>
</div>
