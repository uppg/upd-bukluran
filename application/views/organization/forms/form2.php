<?
	$collections_total = 0;
	$disbursements_total = 0;
	$cash_balance = 0;
?>

<div class="span-19 last" id="content_main">
	<div class="contentHeader_text">
		Form 2 - Financial Statement
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
		Currently viewing form 2 of organization <strong><?= $orgname ?></strong><br/>
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

		<?= form_open("organization/form2_submit/".($this->session->user_group_is(OSA_GROUPID)?"{$appsemid}/{$orgid}":""))?>
			<?=form_label('Starting Cash Balance:','start_bal')?>
			<?=form_input('start_bal',$start_bal).br(2)?>
			<h3>Collections:</h3>
			<div id="collections_no">
			<?=form_hidden('collections_no',count($collections))?>
			</div>
			
			<?= anchor('organization/form2_add_collection'.($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":""),'Add Collection','class="add_collection"').br(2)?>
			<?if(count($collections) > 0):?>			
			<table id = "collections">
				<thead>
				<tr>
					<th>Description</th>
					<th>Amount</th>
					<th>Action</th>
				</tr>
				</thead>
			<?for($i=0;$i<count($collections);$i++):?>
				<tr>
					<td>
					<?=form_hidden('collection_id_'.($i+1),$collections[$i]['orgcollectionid'])?>
					<?=form_input('collection_detail_'.($i+1),$collections[$i]['description'])?>
					</td>
					<td>
					<?=form_input('collection_amount_'.($i+1),$collections[$i]['amount'])?>
					</td>
					<td>
					<?=anchor("organization/delete_collection/{$collections[$i]['orgcollectionid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Delete')?>
					</td>
				</tr>
				<?$collections_total+=$collections[$i]['amount']?>
			<?endfor;?>
			</table>
			<?else:?>
				<div id="no_collections">
					No Collections
					<?=br(2)?>
				</div>
			<?endif;?>
			<h4>Total Collections: <?= $collections_total?></h4>
			
			
			
			
			<h3>Disbursements:</h3>
			
			<div id="disbursements_no">
			<?=form_hidden('disbursements_no',count($disbursements))?>
			</div>
			
			<?= anchor('organization/form2_add_disbursement'.($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":""),'Add Disbursement','class="add_disbursement"').br(2)?>
			<?if(count($disbursements)>0):?>
			<table id = "disbursements">
				<thead>
				<tr>
					<th>Description</th>
					<th>Amount</th>
					<th>Action</th>
				</tr>
				</thead>
			<?for($i=0;$i<count($disbursements);$i++):?>
				<tr>
					<td>
					<?=form_hidden('disbursement_id_'.($i+1),$disbursements[$i]['orgdisbursementid'])?>
					<?=form_input('disbursement_detail_'.($i+1),$disbursements[$i]['description'])?>
					</td>
					<td>
					<?=form_input('disbursement_amount_'.($i+1),$disbursements[$i]['amount'])?>
					</td>
					<td>
					<?=anchor("organization/delete_disbursement/{$disbursements[$i]['orgdisbursementid']}".($this->session->user_group_is(OSA_GROUPID)?"/{$appsemid}/{$orgid}":''),'Delete')?>
					</td>
				</tr>
				<?$disbursements_total+=$disbursements[$i]['amount']?>
			<?endfor;?>
			</table>
			<?else:?>
				<div id="no_disbursements">
					No Disbursements
					<?=br(2)?>
				</div>
			<?endif?>
			<h4>Total Disbursements: <?= $disbursements_total?></h4>
			
			<h4>Cash Balance: <?= $start_bal + $collections_total - $disbursements_total?></h4>
			
			<?= form_submit('submit','Save')?>
		<?= form_close()?>
		
		
		<script>
		/*
			var collections = $('#collections_no > input').val();
			var disbursements = $('#disbursements_no > input').val();
			
			var remove_row = function(){
				$(this).parent('tr').detatch();
			}
			
			var disbursement_click = function(){
				if(disbursements == 0){
					$('<?= anchor('organization/form2_add_disbursement','Add Disbursement','class="add_disbursement_1" style="display:none;"').br(3)?><table id = "disbursements" style="display:none;"><thead><tr><th>Description</th><th>Amount</th></tr></thead></table>').insertBefore(this).fadeIn('slow');
					$('#no_disbursements').hide();
					$('.add_disbursement_1').removeClass('add_disbursement_1').addClass('add_disbursement').click(disbursement_click);
				}
				disbursements++;
				$('#disbursements_no > input').val(disbursements);
				$('<tr style="display:none;"><td><input type="text" name="disbursement_detail_'+disbursements+'"></td><td><input type="text" name="disbursement_amount_'+disbursements+'"></td></tr>').appendTo('#disbursements').fadeIn('slow');
				return false;
			};
			var collection_click = function(){
				if(collections == 0){
					$('<?= anchor('organization/form2_add_collection','Add Collection','class="add_collection_1" style="display:none;"').br(3)?><table id = "collections" style="display:none;"><thead><tr><th>Description</th><th>Amount</th></tr></thead></table>').insertBefore(this).fadeIn('slow');
					$('#no_collections').hide();
					$('.add_collection_1').removeClass('.add_collection_1').addClass('.add_collection').click(collection_click);
				}
				collections++;
				$('#collections_no > input').val(collections);
				$('<tr style="display:none;"><td><input type="text" name="collection_detail_'+collections+'"></td><td><input type="text" name="collection_amount_'+collections+'"></td></tr>').appendTo('#collections').fadeIn('slow');
				return false;
			};
			function init(){
				$('.add_disbursement').click(disbursement_click);
				$('.add_collection').click(collection_click);
			}
			init();
		*/
		</script>
</div>

