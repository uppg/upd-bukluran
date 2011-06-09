<div class="span-14 prepend-5 append-5" id="content">
	<div class="contentHeader_text middle">
		Login for Students and Faculty
	</div>
		<? if(validation_errors()):?>
			<?= validation_errors(); ?>
		<?endif?>
		<?= form_open('login/link_submit',array('class'=>'form_large','method'=>'post'))."\n";?>
			<?= form_label('Code','link',array('class'=>'label')).br(1)."\n"; ?>
			<?= form_input(array('type'=>'text','name'=>'link','id'=>'link','value'=>$link,'size'=>'23','class'=>'text_input')).br(1)."\n";?>
			<?= form_submit('submit','Login','class="submit_default" id="submit"')."\n";?>
		<?= form_close().br(2)."\n";?>
		
		For Organizations and OSA, click <?=anchor('login','here')?>.
</div>
