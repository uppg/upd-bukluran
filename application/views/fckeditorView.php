<?php

$this->load->helper('form');
echo '<h1>FckEditor</h1>';
echo form_open('main/fckeditorshowpost');

echo $this->fckeditor->Create() ;

echo form_submit(array('value'=>'submit'));
echo form_close(); 

?>