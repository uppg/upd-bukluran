<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Announcements
	</div>
	<?php if(isset($announcement)):?>
	<div class="announcement">
		<div class="announcementDetails_title">
			<?=$announcement['title']?>
		</div>
		<div class="announcementDetails_postInfo">
			posted by <span class="announcementDetails_username"><?=$announcement['username']?></span> at <span class="announcementDetails_date"><?=$announcement['date_created']?></span>. last modified at <span class="announcementDetails_date"><?=$announcement['date_modified']?></span>.
		</div>
		<div class="announcementDetails_content">
			<?=$announcement['content']?>
		</div>
	</div>
	<?php endif; ?>
	<?=anchor($back_link.$page_no,'Back to List');?>
</div>