<div class="span-14 prepend-5 append-5" id="content">
	<div class="contentHeader_text middle">
		Lost Password
	</div>
		<? if(validation_errors()):?>
			<?= validation_errors(); ?>
		<?endif?>
		The username and password will be sent to the Organization Head's Email Address.<?=br(2)?>
		If you have also lost the username, please proceed to OSA to retrieve it.<?=br(2)?>
		<?= form_open('login/lost_pass_submit',array('class'=>'form_large','method'=>'post'))."\n";?>
			<?= form_label('Username:','username',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'text','name'=>'username','id'=>'username','value'=>'','size'=>'23','class'=>'text_input')).br(1)."\n";?>
			<?= form_submit('Submit','Submit','class="submit_default" id="submit"')."\n";?>
		<?= form_close().br(2)."\n";?>
		
		For Students and Faculty, click <?=anchor('login/lost_link','here')?>.

<script type="text/javascript">
	$('.form_large #submit').removeClass('submit_default').button();
</script>

</div>
