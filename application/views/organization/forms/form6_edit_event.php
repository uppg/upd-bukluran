<?php 
	$description = set_value('description') == ''? $plannedevent['description']:set_value('description');
	$eventname = set_value('eventname') == ''? $plannedevent['eventname']:set_value('eventname');
	$eventdate = set_value('eventdate') == ''? strtotime($plannedevent['eventdate']):set_value('eventdate');
	$eventcategory = set_value('eventcategory') == ''? $plannedevent['eventcategoryid']:set_value('eventcategory');
	$venue = set_value('venue') == ''?$plannedevent['venue']: set_value('venue');
	$this->fckeditor->Value = htmlspecialchars_decode($description);
?>

<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Form 6
	</div>
	<?if($this->session->user_group_is(ORG_GROUPID) && !$this->Variable->app_is_open()):?>
		Registration is Currently Closed.
	<?else:?>
	
	<p>
	Currently viewing form 6 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<?= validation_errors() ?>
	<?=form_open($submit_url)?>
	<table>
		<tr>
			<td><?=form_label('Event name: ','')?></td>
			<td><?=form_input('eventname',$eventname)?></td>
		</tr>
		<tr>
			<td><?=form_label('Event date: (yyyy-mm-dd):','date_established')?></td>
			<td><?=form_input('eventdate',date("Y-m-d",$eventdate),'class="datepicker"')?></td>
		</tr>
		<tr>
			<td><?=form_label('Venue:','venue')?></td>
			<td><?=form_input('venue',$venue)?></td>
		</tr>
		<tr>
			<td><?=form_label('Event Category:','eventcategory')?></td>
			<td><?=form_dropdown('eventcategory',$eventcategories,$plannedevent['eventcategoryid'])?></td>
		</tr>
		<tr>
			<td><?=form_label("Description:",'description')?></td>
			<td><?=$this->fckeditor->Create();?></td>
		</tr>
	</table>
	
	<?=form_submit('submit','Save')?>
	<?=form_button('cancel','Cancel')?>
	<?=form_close()?>
	
	<? endif; ?>
</div>

<script>
	$(document).ready(
		function() {
			$('.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd',
				minDate: '1908-06-01'
			});
			$('.radio').buttonset();
			if($('#sec_incorporated_no').attr('checked')){
				$('#incorporated').hide();
			}
			$('#sec_incorporated_yes').click(function(){
				$('#incorporated').fadeIn('slow');
				}).css('position','absolute');	
			$('#sec_incorporated_no').click(function(){
				$('#incorporated').fadeOut('slow');
				$('#incorporated :input').attr('value','');
			}).css('position','absolute');
		}
	);
</script>