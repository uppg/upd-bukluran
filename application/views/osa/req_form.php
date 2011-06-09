<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		<? if($action === ACTION_ADD_REQ): ?>
			Add
		<? elseif($action === ACTION_EDIT_REQ): ?>
			Edit
		<? endif; ?>
		a Requirement
	</div>

	<?= anchor("osa/manage_reqs/{$appsemid}", 'Back to Manage Requirements') ?>
	
	<p><?= $this->session->validation_errors() ?></p>
	
	<? if($action === ACTION_ADD_REQ): ?>
		Adding
	<? elseif($action === ACTION_EDIT_REQ): ?>
		Editing
	<? endif; ?>
	a requirement for application period: <strong><?= $pretty_application_aysem ?></strong>
	<?= form_open($submit_url) ?>
	<?= form_hidden('appsem',$appsemid)?>
	<table>
		<tr>
			<td><?= form_label('Name:', 'name') ?></td>
			<td><?= form_input('name', $postback['name']?:$name, 'maxlength="'.REQ_NAME_MAXLENGTH.'" size="46"') ?></td>
		</tr>
		<tr>
			<td><?= form_label('Description:', 'description') ?></td>
			<td><?= form_textarea('description', $postback['description']?:$description) ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?
					$submittext = NULL;
					if($action === ACTION_ADD_REQ)
						$submittext = 'Add Requirement';
					else if($action === ACTION_EDIT_REQ)
						$submittext = 'Edit Requirement';
				?>
				
				<?= form_submit('submit', $submittext) ?>
			</td>
		</tr>
	</table>
	<?= form_close() ?>
</div>
