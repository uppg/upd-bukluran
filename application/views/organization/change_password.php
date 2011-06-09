<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Change Password
	</div>
	<? if(validation_errors()):?>
		<?= validation_errors(); ?>
	<?endif?>	
	<?= form_open(($this->session->user_group_is(OSA_GROUPID)?'osa':'organization')."/change_password_submit",array('class'=>'form_large'))."\n";?>
			<?= form_label('Current Password','old_pass',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'password','name'=>'old_pass','id'=>'old_pass','size'=>'23','class'=>'text_input')).br(3)."\n";?>
			
			<?= form_label('New Password','new_pass_1',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'password','name'=>'new_pass_1','id'=>'new_pass_1','size'=>'23','class'=>'text_input')).br(1)."\n";?>
			
			<?= form_label('New Password Confirmation','new_pass_2',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'password','name'=>'new_pass_2','id'=>'new_pass_2','size'=>'23','class'=>'text_input')).br(3)."\n";?>

			<?= form_submit('submit','Change Password','class="submit_default" id="submit"')."\n";?>
			
	<?= form_close()."\n";?>
	
</div>

<script type="text/javascript">
	$('#submit').removeClass('submit_default').button();
</script>