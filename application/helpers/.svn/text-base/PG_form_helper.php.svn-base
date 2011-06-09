<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function result_to_option_array($result_array, $key, $value){
	$option_array = array();
	
	foreach($result_array as $result)
		$option_array[$result[$key]] = $result[$value];
	
	return($option_array);
}
