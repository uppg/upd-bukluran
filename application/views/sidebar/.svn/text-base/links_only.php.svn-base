<div class="span-5" id="content_sidebar">
	<? foreach($links as $link):?>
		<div class='sidebar_links'>
			<h1><?=$link['title']?></h1>
			<?php for($i=0;$i<count($link['hrefs']);$i++): ?>
				<? if($link['selected']==$i):?>
					<span class="selected"><?=$link['anchors'][$i]?></span>
				<?else:?>
					<?= anchor($link['hrefs'][$i],$link['anchors'][$i])?>
				<?endif;?>
			<?php endfor;?>
		</div>
	<?endforeach;?>
</div>