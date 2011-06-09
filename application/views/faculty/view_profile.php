<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		View Profile
	</div>
	<?if($messages):?>
	<?foreach($messages as $message):?>
	<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all notification">
		<span class="ui-icon ui-icon-info notification-icon"></span> 
		<?=$message?>
		<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span> 
	</div>
	</div>
	<?endforeach;?>
	<?endif;?>
	<?if($has_profile):?>
		<b>Name:</b> <?=$faculty['lastname'].', '.$faculty['firstname'].' '.$faculty['middlename'].br(1)?>
		<b>Department:</b> <?=$faculty['department'].br(1)?>
		<b>College:</b> <?=$faculty['college'].br(1)?>
		<b>Faculty Position and Rank:</b> <?=$faculty['faculty_position_and_rank'].br(2)?>
		<b>Mobile Number:</b> <?=$faculty['mobile_number'].br(1)?>
		<b>Home Number:</b> <?=$faculty['home_number'].br(1)?>
		<b>Office Number:</b> <?=$faculty['office_number'].br(2)?>
	<?endif;?>
		<b>UP Webmail:</b> <?=$faculty['webmail'].br(1)?>
		
	<?= anchor('faculty/edit_profile','Edit Profile') ?>
</div>