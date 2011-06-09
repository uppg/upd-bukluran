<div class="span-14 prepend-5 append-5" id="content">
	<div class="contentHeader_text middle">
		Lost Confirmation Code
	</div>
		<? if(validation_errors()):?>
			<?= validation_errors(); ?>
		<?endif?>
		
		The Confirmation Code will be sent to your UP Webmail Address.<?=br(2)?>
		
		<?= form_open('login/lost_link_submit',array('class'=>'form_large','method'=>'post'))."\n";?>
			<?= form_label('UP Webmail:','webmail',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'text','name'=>'webmail','id'=>'webmail','value'=>'','size'=>'23','class'=>'text_input')).br(1)."\n";?>
			<?= form_submit('submit','Submit','class="submit_default" id="submit"')."\n";?>
		<?= form_close().br(2)."\n";?>
		
		For Organizations, click <?=anchor('login/lost_pass','here')?>.

<script type="text/javascript">
	$('.form_large #submit').removeClass('submit_default').button();
</script>

</div>
