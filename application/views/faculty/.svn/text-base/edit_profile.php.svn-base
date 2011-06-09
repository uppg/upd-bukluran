<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Edit Profile
	</div>

	<?= validation_errors(); ?>

	<?= form_open('faculty/edit_profile_submit',array('class'=>'form_large','method'=>'post'))."\n"?>
		<?= form_label('First Name','firstname',array('class'=>'label'))."\n"; ?>
		<?= form_input(array('name'=>'firstname','id'=>'firstname','value'=>set_value('firstname',$faculty['firstname']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		<?= form_label('Middle Name','middlename',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'middlename','id'=>'middlename','value'=>set_value('middlename',$faculty['middlename']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		<?= form_label('Last Name','lastname',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'lastname','id'=>'lastname','value'=>set_value('lastname',$faculty['lastname']),'type'=>'text','size'=>'23','class'=>'text_input')).br(5)."\n";?>
		
		<?= form_label('Department','department',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'department','id'=>'department','value'=>set_value('department',$faculty['department']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		<?= form_label('College','college',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'college','id'=>'college','value'=>set_value('college',$faculty['college']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		<?= form_label('Faculty Position and Rank','faculty_position_and_rank',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'faculty_position_and_rank','id'=>'faculty_position_and_rank','value'=>set_value('faculty_position_and_rank',$faculty['faculty_position_and_rank']),'type'=>'text','size'=>'23','class'=>'text_input')).br(5)."\n";?>
		
		<?= form_label('Mobile Number','mobile_number',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'mobile_number','id'=>'mobile_number','value'=>set_value('mobile_number',$faculty['mobile_number']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		<?= form_label('Home Number','home_number',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'home_number','id'=>'home_number','value'=>set_value('home_number',$faculty['home_number']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		<?= form_label('Office Number','office_number',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'office_number','id'=>'office_number','value'=>set_value('office_number',$faculty['office_number']),'type'=>'text','size'=>'23','class'=>'text_input')).br(5)."\n";?>
		
		<?= form_label('UP Webmail','webmail',array('class'=>'label')).br(1)."\n"; ?>
		<?= form_input(array('name'=>'webmail','id'=>'webmail','value'=>set_value('webmail',$faculty['webmail']),'type'=>'text','size'=>'23','class'=>'text_input')).br(1)."\n";?>
		
		
		<?= form_submit('submit','Save Profile','class="submit_default" id="submit"')."\n";?>
	<?= form_close()."\n"?>	
</div>