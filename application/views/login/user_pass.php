<div class="span-14 prepend-5 append-5" id="content">
	<div class="contentHeader_text middle">
		Login for Organizations and OSA
	</div>
		<? if(validation_errors()):?>
			<?= validation_errors(); ?>
		<?endif?>
		<?= form_open('login/',array('class'=>'form_large'))."\n";?>
			<?= form_label('Username','username',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'text','name'=>'username','id'=>'username','value'=>set_value('username'),'size'=>'23','class'=>'text_input')).br(1)."\n";?>			
			<?= form_label('Password','password',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'password','name'=>'password','id'=>'password','size'=>'23','class'=>'text_input')).br(1)."\n";?>
			<!--
			<?= form_input(array('type'=>'checkbox','name'=>'rememberme','id'=>'rememberme','value'=>'forever'))."\n";?>
			
			<?= form_label('Remember me','rememberme',array('class'=>'label'))."\n"; ?>
			-->
			<?= form_submit('submit','Log in','class="submit_default" id="submit"')."\n";?>
			
		<?= form_close()."\n";?>
		<!--
		<?=anchor('login/lost_pass','Lost your password?').br(2)."\n";?>
		-->
		For Students and Faculty, click <?=anchor('login/link','here')?>.
</div>
