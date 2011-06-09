<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Forms 3 and 4 - Officer and Member Roster
	</div>
	<?if($this->session->user_group_is(ORG_GROUPID) && !$this->Variable->app_is_open()):?>
	<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all notification">
		<span class="ui-icon ui-icon-info notification-icon"></span> 
		Registration is Currently Closed.
		<span class="ui-icon ui-icon-close notification-close" style="display:none;"></span> 
	</div>
	</div>
	<?=br()?>
	<?endif;?>
	
	<p>
	Currently viewing form 3 of organization <strong><?= $orgname ?></strong><br/>
	for application period <strong><?= $pretty_application_aysem ?></strong>
	</p>
	
	<? if($this->session->user_group_is(OSA_GROUPID) && count($appsems) > 1): ?>
	
	<?= form_open($change_appsem_submit_url) ?>
	View application form for different application period:
	<?= form_dropdown('appsem', $appsems, $appsemid) ?>
	<?= form_hidden('orgid',$orgid)?>
	<?= form_submit('submit', 'Go') ?>
	<?= form_close(); ?>
	
	<? endif; ?>
	
	<p>
	<h2>Officer Roster</h2>
	
	<? if(count($officers) > 0): ?>
	
	<?= anchor($add_officer_url, 'Add An Officer') ?>
	
	<table id="officers">
	<thead>
	<tr>
		<th>UP Webmail</th>
		<th>Email Address</th>
		<th>Position</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($officers as $officer): ?>
		<tr>
			<td><?= $officer['webmail'] ?></td>
			<td><?= $officer['email'] ?></td>
			<td><?= $officer['position'] ?></td>
			<td><?= $officer['confirmed'] == 't'?'Confirmed':'Not Confirmed'?></td>
			<td>
				<?= anchor("organization/delete_member/{$officer['studentid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Delete').br()?>
				<?= anchor("organization/send_member_confirmation_email/{$officer['studentid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Send Confirmation').br()?>
				<?= anchor("student/upload/{$officer['studentid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Upload UP ID')?> <span id="progress_form3" class="ui-icon ui-icon-<?=($officer['studentpictureid'])?"check":"closethick"?> progress-check-icon"></span><?=br()?>
				<?if($this->session->user_group_is(OSA_GROUPID)){
					if($officer['confirmed']=='t'){
						echo anchor("student/unconfirm/{$orgid}/{$appsemid}/{$officer['studentid']}",'Unconfirm');
					}else{
						echo anchor("student/confirm/{$orgid}/{$appsemid}/{$officer['studentid']}",'Confirm');
					}
				}?>
			</td>
		</tr>
	<? endforeach; ?>
	</tbody>
	</table>
	
		<div id="pagination_officers">
		<?=form_open()?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/first.png",'class'=>"first"))?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/prev.png",'class'=>"prev"))?>
			<?=form_input(array('class'=>'pagedisplay'))?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/next.png",'class'=>"next"))?> 
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/last.png",'class'=>"last"))?> 
			<?=form_dropdown('pagesize',array(
				10=>10,
				20=>20,
				30=>30,
				40=>40
			),'10','class="pagesize"')?>
		<?=form_close()?>
		Search: <input name="filter" id="filter-box_officers" value="" maxlength="30" size="30" type="text"> <input id="filter-clear-button_officers" type="submit" value="Clear"/>
	</div>
	
	<script>
		$('#officers')
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pagination_officers")})
		.tablesorterFilter({filterContainer: $("#filter-box_officers"),
                          filterClearContainer: $("#filter-clear-button_officers"),
                          filterColumns: [0],
                          filterCaseSensitive: false});
						  
		$(document).ready(function(){
			$('#officers').addClass('tablesorter');
		});
	</script>
	
	<? else: ?>
	
	<p>No officers listed</p>
	
	<? endif; ?>
	
	<?= anchor($add_officer_url, 'Add An Officer') ?>
	</p>
	
	<p>
	<h2>Member Roster</h2>
	
	<? if(count($members) > 0): ?>
	
	<?= anchor($add_member_url, 'Add A Member') ?>
	
	<table id="members">
	<thead>
	<tr>
		<th>UP Webmail</th>
		<th>Email Address</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($members as $member): ?>
		<tr>
			<td><?= $member['webmail'] ?></td>
			<td><?= $member['email'] ?></td>
			<td><?= $member['confirmed'] == 't'?'Confirmed':'Not Confirmed'?></td>
			<td>
				<?= anchor("organization/delete_member/{$member['studentid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Delete').br()?>
				<?= anchor("organization/send_member_confirmation_email/{$member['studentid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Send Confirmation').br()?>
				<?= anchor("student/upload/{$member['studentid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Upload UP ID')?> <span id="progress_form3" class="ui-icon ui-icon-<?=($member['studentpictureid'])?"check":"closethick"?> progress-check-icon"></span><?=br()?>
				<?if($this->session->user_group_is(OSA_GROUPID)){
					if($member['confirmed']=='t'){
						echo anchor("student/unconfirm/{$orgid}/{$appsemid}/{$member['studentid']}",'Unconfirm');
					}else{
						echo anchor("student/confirm/{$orgid}/{$appsemid}/{$member['studentid']}",'Confirm');
					}
				}?>
			</td>
		</tr>
	<? endforeach; ?>
	</tbody>
	</table>
	<div id="pagination_members">
		<?=form_open()?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/first.png",'class'=>"first"))?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/prev.png",'class'=>"prev"))?>
			<?=form_input(array('class'=>'pagedisplay'))?>
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/next.png",'class'=>"next"))?> 
			<?=img(array('src'=>"layout/images/tablesorter.pager.icons/last.png",'class'=>"last"))?> 
			<?=form_dropdown('pagesize',array(
				10=>10,
				20=>20,
				30=>30,
				40=>40
			),'10','class="pagesize"')?>
		<?=form_close()?>
		Search: <input name="filter" id="filter-box_members" value="" maxlength="30" size="30" type="text"> <input id="filter-clear-button_members" type="submit" value="Clear"/>
	</div>
	
	<script>
		$('#members')
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pagination_members")})
		.tablesorterFilter({filterContainer: $("#filter-box_members"),
                          filterClearContainer: $("#filter-clear-button_members"),
                          filterColumns: [0],
                          filterCaseSensitive: false});
						  
		$(document).ready(function(){
			$('#members').addClass('tablesorter');
		});
	</script>
	
	<? else: ?>
	
	<p>No members listed</p>
	
	<? endif; ?>
	
	<?= anchor($add_member_url, 'Add A Member') ?>
	</p>
	<?= anchor("organization/send_member_confirmation_emails".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Send Confirmation Emails')?>
</div>


