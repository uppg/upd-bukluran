<?php
$config['base_url'] = site_url($site_link);
$config['total_rows'] = count($orgs); //TODO:GET FROM MODEL
$config['per_page'] = '20'; 

$this->pagination->initialize($config); 
?>
<div class="span-<?=isset($span)?$span:24?> last" id="content_main">
	<div class="contentHeader_text">
		Organizations List
	</div>
	<?php if(isset($orgs)):?>
	<table class="tablesorter">
	<thead>
		<tr>
			<th>Organization</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($orgs as $org):?>
		<tr>
			<td><?=$org['orgname']?></td>
			<td><?=anchor($forward_link.$org['organizationid'], 'View Profile')?></td>
		</tr>
		<? endforeach;?>
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
	<?php endif;?>
</div>
