<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		<?= $title ?>
	</div>
	
	<? if(validation_errors()): ?>
		<?= validation_errors() ?>
	<? endif;?>
<? 
$this->load->helper('form');
$this->fckeditor->Value = $announcement['content'];
?>

<?=form_open($submit_url);?>
<? if(array_key_exists('announcementid',$announcement)):?>
	<?= form_hidden('announcementid',$announcement['announcementid']);?>
<? endif;?>
<?=form_label('Title:','title');?>
<?=form_input('title',$announcement['title']);?>
<?=br(1);?>
<?=form_label('Content:','content');?>
<?=$this->fckeditor->Create();?>
<?=form_submit('submit','Submit');?>
<?=form_close();?>
</div>
