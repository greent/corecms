<?php

	if ($legal_require_php!=333666999) exit;
	
	require('functions.php');
	
	connect();
	
	// setup global variable $global_user_id, set it to 0, which means no user as auto_increment IDs in MySQL begin with 1
	$global_user_id = 0;
	
	// now, check if user’s computer has the cookie set
	if (isset($_COOKIE['fotodiskont'])) {
		$cookieval= $_COOKIE['fotodiskont'];
		
		//now parse the ID:LOGCODE value in cooke via explode() function
		$cookieparsed = explode (":", $cookieval);
		
		// $cookie_uid will hold user’s id
		// $cookie_code will hold user’s last reported logcode
		$cookie_uid = $cookieparsed[0];
		$cookie_code = $cookieparsed[1];
		$cookie_type = 'username';
		
		// ensure that ID from cookie is a numeric value
		if (is_numeric($cookie_uid)) {
			
			//now, find the user via his ID
			$res = mysql_query("SELECT logcode FROM $cookie_type WHERE id=$cookie_uid");
			
			
			// no die() this time, we will redirect if error occurs
			if ($res) {
			
				// now see if user’s id exists in database
				if (mysql_num_rows($res)) {
					
					$logcode_in_base = mysql_result($res, 0);
					// now compare LOGCODES in cookie against the one in database
					if ($logcode_in_base == $cookie_code) {
						// if valid, generate new logcode and update database
						$newcode = md5(func_generate_string());
						$res = mysql_query("UPDATE $cookie_type SET logcode='$newcode' WHERE id=$cookie_uid");
						// setup new cookie (replace the old one)
						$newval= "$cookie_uid:$newcode:$cookie_type";
						setcookie("sbncors", $newval, time() + 3000);
						// finally, setup global var to reflect user’s id
						$global_user_id = $cookie_uid;
						$global_type = 'username';
						$loginSuccess = 1;
					} else {
						$loginSuccess = 0;
					}
				} else {
					$loginSuccess = 0;
				}
			} else {
				$loginSuccess = 0;
			}
		} else {
			$loginSucccess = 0;
		}
	}
	


	disconnect();
	

?>