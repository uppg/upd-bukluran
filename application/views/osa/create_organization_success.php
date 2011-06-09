<div class="span-19 last" id="content_main">
<div class="contentHeader_text">
	<?= $title ?>
</div>
<div class="last" id="content_main">
	Username: <?= $username ?><br/>
	Password: <code><?= $password ?></code><br/>

	<?= anchor('osa/create_organization', 'Add Another Organization') ?><br/>
	<?= anchor('osa/organizations', 'Manage Organizations') ?>
</div>
</div>
