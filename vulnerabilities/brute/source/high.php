<?php

if( isset( $_GET[ 'Login' ] ) ) {

	// Sanitise username input
	$user = $_GET[ 'username' ];
	$user = stripslashes( $user );
	$user = mysql_real_escape_string( $user );

	// Sanitise password input
	$pass = $_GET[ 'password' ];
	$pass = stripslashes( $pass );
	$pass = mysql_real_escape_string( $pass );
	$pass = md5( $pass );

	if (blocked_user($user)) {
		sleep(3);
		$html .= "<pre><br>Block user on 5 unsuccessful login attempts.</pre>";
	} else {
		$qry = "SELECT * FROM `users` WHERE user='$user' AND password='$pass';";
		$result = mysql_query($qry) or die('<pre>' . mysql_error() . '</pre>' );

		if( $result && mysql_num_rows( $result ) == 1 ) {
			// Get users details
			$i=0; // Bug fix.
			$avatar = mysql_result( $result, $i, "avatar" );
			
			// Login Successful
			reset_login_attempts($user);

			$html .= "<p>Welcome to the password protected area " . $user . "</p>";
			$html .= '<img src="' . $avatar . '" />';
		} else {
			// Login failed
			increase_login_attempts($user);

			sleep(3);
			$html .= "<pre><br>Username and/or password incorrect.</pre>";
		}
	}

	mysql_close();
}

function reset_login_attempts($user){
	$update = "UPDATE `users` set login_attempts='0' WHERE user='$user';";
	mysql_query($update) or die('<pre>' . mysql_error() . '</pre>' );
}

function increase_login_attempts($user){
	$update = "UPDATE `users` set login_attempts=login_attempts+1 WHERE user='$user';";
	mysql_query($update) or die('<pre>' . mysql_error() . '</pre>' );
}

function blocked_user($user){
	$max_login_attempts = 5;

	$qry = "SELECT * FROM `users` WHERE user='$user';";
	$result = mysql_query($qry) or die('<pre>' . mysql_error() . '</pre>' );

	if ($result && mysql_num_rows($result) == 1) {
		$i=0;
		$login_attempts = mysql_result($result, $i, "login_attempts");

		return $login_attempts >= $max_login_attempts; 
	}

	return false;
}

?>