<?php
$config['base_url'] = site_url($site_link);
$config['total_rows'] = $total;
$config['per_page'] = $limit; 

$this->pagination->initialize($config); 
?>

<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Announcements
	</div>
	<?php if(isset($announcements)):?>
		<?php foreach($announcements as $announcement):?>
	<div class="announcement">
		<div class="announcementDetails_title">
			<?=anchor($forward_link.$page_no.'/'.$announcement['announcementid'],$announcement['title'])?>
		</div>
		<div class="announcementDetails_postInfo">
			posted by <span class="announcementDetails_username"><?=$announcement['username']?></span> at <span class="announcementDetails_date"><?=$announcement['date_created']?></span>. last modified at <span class="announcementDetails_date"><?=$announcement['date_modified']?></span>. <?= $this->session->user_group_is(OSA_GROUPID)?anchor('osa/edit_announcement/'.$announcement['announcementid'],'edit').'&nbsp;'.anchor('osa/delete_announcement/'.$announcement['announcementid'],'delete'):'' ?>
		</div>
		<div class="announcementDetails_content">
			<?=$announcement['content']?>
		</div>
	</div>
		<?php endforeach;?>
		<?=$this->pagination->create_links();?>
	<?php endif; ?>
</div>
