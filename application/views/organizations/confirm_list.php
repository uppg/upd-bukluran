<?php
$config['base_url'] = site_url($site_link);
$config['total_rows'] = count($orgs); //TODO: should be passed from model
$config['per_page'] = '20'; 

$this->pagination->initialize($config); 
?>
<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Manage Organizations
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
	<?php if(isset($orgs) && count($orgs) > 0):?>
	<table class="tablesorter">
	<thead>
		<tr>
			<th>Organization</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($orgs as $org): ?>
		<tr>
		<td><?= $org['orgname'] ?></td>
		<td><?if($org['confirmed']=='t'):?>
				Confirmed
			<?else:?>
				Not Yet Confirmed
			<?endif;?></td>
		<td>
			<?if( !$this->session->user_group_is(OSA_GROUPID) && $this->Variable->app_is_open()):?>
				<?if($org['confirmed']=='t'):?>
					<?= anchor($unconfirm_link.$org['organizationid'],'Unconfirm') ?>
				<?else:?>
					<?= anchor($confirm_link.$org['organizationid'],'Confirm') ?>
				<?endif;?>
			<?endif;?>
		</td>
		</tr>
		<?php endforeach;?>
	</tbody>
	</table>
	<div id="pagination">
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
		Search: <input name="filter" id="filter-box" value="" maxlength="30" size="30" type="text"> <input id="filter-clear-button" type="submit" value="Clear"/>
	</div>
	<!--
	<?=$this->pagination->create_links();?>
	-->
	<br/>
	<?php endif;?>
</div>