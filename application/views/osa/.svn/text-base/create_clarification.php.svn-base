<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		<?= $title ?>
	</div>
	
	<? if(validation_errors()): ?>
		<?= validation_errors() ?>
	<? endif;?>
<? 
$this->load->helper('form');
$this->fckeditor->Value = $clarification['description'];
?>

<?=form_open($submit_url);?>
<? if(array_key_exists('orgclarificationid',$clarification)):?>
	<?= form_hidden('orgclarificationid',$clarification['orgclarificationid']);?>
<? endif;?>
<?=form_label('Content:','content');?>
<?=$this->fckeditor->Create();?>
<?=form_submit('submit','Submit');?>
<?=form_close();?>

<?=anchor($back_url,'Back')?>
</div>
