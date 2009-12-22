<?php

function authenticate($_configs, $_params){
	foreach($_configs as $_config){
		if (authenticateSingle($_config, $_params)){
			return true;
		}
	}
	return false;
}

function authenticateSingle($_config, $_params){
	$_action = $_config["action"];
	if ($_config == null){
		return;
	}
	
	// build conditions, init const settings
	$_conditions = $_config["const"];
	
	// build array conditoins
	$_arrays = $_config["array"];
	foreach($_arrays as $key => $value){
		$_cur_arr = $_params[$key];
		foreach($value as $condition){
			if (!isset($_cur_arr[$condition[0]])) {
				return false;
			}
			$_conditions[] = 
				array($_cur_arr[$condition[0]], $condition[1], $condition[2]);
		}		
	}
	
	// take action if not satisfied
	if (!satisfy($_conditions)){
		return false;
	}
	return true;
}

function satisfy($conditions){
	foreach($conditions as $condition){
		if (!isset($condition[0]) ||
			($condition[0] == $condition[1]) != $condition[2]){
			return false;
		}
	}
	return true;
}

?>