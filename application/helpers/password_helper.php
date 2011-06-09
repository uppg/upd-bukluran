<?php

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('generate_password'))
	{
	function generate_password($length = 8){
		$validchars = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

		$password  = "";
		$counter   = 0;

		while ($counter < $length) {
			$randdex = rand(0, strlen($validchars)-1);
			$randchar = substr($validchars, $randdex, 1);

			// All character must be different
			if (!strstr($password, $randchar)) {
				$password .= $randchar;
				$counter++;
			}
		}

		return $password;
	}
	}