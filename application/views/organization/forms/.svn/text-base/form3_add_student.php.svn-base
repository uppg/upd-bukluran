<div class="span-19 last" id="content_main">
	<? 
		$this->load->helper('inflector');
		$studenttype = $isofficer?'officer':'member';
		$ucstudenttype = ucfirst($studenttype);
	?>

	<div class="contentHeader_text">
		Form 3 Subform - Add <?= $ucstudenttype ?>
	</div>
	
	<?if($this->session->user_group_is(ORG_GROUPID) && !$this->Variable->app_is_open()):?>
		Registration is Currently Closed.
	<?else:?>
	
	<p><?= $this->session->validation_errors() ?></p>
	
	<p>
	Currently adding <?= articlize($studenttype) ?> to form 3 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<?= form_open($submit_url) ?>
	<table>
	<tr>
		<td><?= form_label('UP Webmail (e.g., fmlastname@up.edu.ph)', 'webmail') ?></td>
		<td><?= form_input('webmail', $postback['webmail']) ?></td>
	</tr>
	<tr>
		<td><?= form_label('Email Address', 'email') ?></td>
		<td><?= form_input('email', $postback['email']) ?></td>
	</tr>
	<? if($isofficer): ?>
	<tr>
		<td><?= form_label('Position', 'position') ?></td>
		<td><?= form_input('position', $postback['position']) ?></td>
	</tr>
	<? endif; ?>
	<tr>
		<td></td>
		<td><?= form_submit('submit', "Add {$ucstudenttype}") ?></td>
	</tr>
	</table>
	<?= form_close() ?>
	<?endif;?>
</div>
