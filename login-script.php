<?php

	require ('functions.php');
	
	connect();
	
// Check if the script received required values
	if (isset($_POST['username']) && isset($_POST['password'])) {
	// trim and read username and password from the form
		$username= ltrim(rtrim(addslashes($_POST['username'])));
		$password= ltrim(rtrim(addslashes($_POST['password'])));
		$login_type = 'userdata';
		
		 // generate a MD5 hash of the password
		$mdpass= md5($password);
		
		$res= mysql_query("SELECT id FROM $login_type WHERE account='$username' AND password='$mdpass'") or die("Could not select user ID.");
		
		if (mysql_num_rows($res)==1) {
			$user_obj= mysql_fetch_object($res);
			$user_id= $user_obj->id;
			
			// generate a random 8 char long string, and hash it with MD5
			$logcode= md5(func_generate_string());
			
			// now update user’s information in the database
			$res= mysql_query("UPDATE $login_type SET logcode='$logcode' WHERE id=$user_id") or die("Could not update database.");
			// now, let us setup the identification information that will be passed to user’s computer via a cookie
			// we will store user’s ID and LOGCODE in ID:LOGCODE form so that we can later extract it using explode() function
			$newval= "$user_id:$logcode:$login_type";
			// store the cookie
             setcookie("fotodiskont", $newval, time() + 3000);
			
			header("Location: main.php");
		} else {
			echo 'bad login';
		} 
	} else {
		
		echo 'bad login';
	
	}

?>