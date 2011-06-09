<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function articlize($str){
	if(begins_with_vowel($str))
		return("an $str");
	else
		return("a $str");
}

function begins_with_vowel($str){
	return(in_array(strtolower($str[0]), array('a', 'e', 'i', 'o', 'u')));
}
