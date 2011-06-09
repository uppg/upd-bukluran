<? $this->fckeditor->Value = htmlspecialchars_decode(set_value('description'))?>

<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Form 5
	</div>
	<?if($this->session->user_group_is(ORG_GROUPID) && !$this->Variable->app_is_open()):?>
		Registration is Currently Closed.
	<?else:?>
	
	<p>
	Currently viewing form 5 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<?= validation_errors() ?>
	<?=form_open($submit_url)?>
	<table>
		<tr>
			<td><?=form_label('Award name: ','awardname')?></td>
			<td><?=form_input('awardname',set_value('awardname'))?></td>
		</tr>
		<tr>
			<td><?=form_label('Award Classification:','awardclassification')?></td>
			<td><?=form_dropdown('awardclassification',$awardclassifications)?></td>
		</tr>
		<tr>
			<td><?=form_label("Description:",'description')?></td>
			<td><?=$this->fckeditor->Create();?></td>
		</tr>
		<tr>
			<td><?=form_label("Giver",'giver')?></td>
			<td><?=form_input('giver',set_value('giver'))?></td>
		</tr>
	</table>
	
	<?=form_submit('submit','Add Award')?>
	<?=form_close()?>
	
	<? endif; ?>
</div>