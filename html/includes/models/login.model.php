<?php

class Login
{
	static function loginProcess($email, $password) 
	{
		global $mysqli;
		// Using prepared Statements means that SQL injection is not possible. 
		if ($stmt = $mysqli->prepare("SELECT id, username, timezone, dst, password, salt FROM members WHERE email = ? LIMIT 1")) 
		{ 
			$stmt->bind_param('s', $email); // Bind "$email" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			$stmt->bind_result($user_id, $username, $timezone, $dst, $db_password, $salt); // get variables from result.
			$stmt->fetch();
			$password = hash('sha512', $password.$salt); // hash the password with the unique salt.
 
			if($stmt->num_rows == 1) 
			{ // If the user exists
				// We check if the account is locked from too many login attempts
				if(self::checkBrute($user_id, $mysqli) == true) 
				{ 
					// Account is locked
					// Send an email to user saying their account is locked
					return false;
				} 
				else 
				{
					if($db_password == $password) 
					{ // Check if the password in the database matches the password the user submitted. 
						// Password is correct!
 
						$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
						$user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
						$_SESSION['user_id'] = $user_id; //user who logged in
						$_SESSION['username'] = $username; // we check log status with this two
						
						$_SESSION['timezone'] = $timezone; // current timezone
						$_SESSION['dst'] = $dst; // if dst is set 
						 
						$_SESSION['rater_id'] = $user_id; //user that commits the rate
						$_SESSION['rated_id'] = $user_id; //user that recieves the rate
						
						$_SESSION['profile_username'] = $username;
						$_SESSION['profile_id'] = $user_id;
						
						$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
						
						$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
						
						// Login successful.
						return true;    
					} 
					else 
					{
						// Password is not correct
						// We record this attempt in the database
						$now = time();
						$mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
						return false;
					}
				}
			} 
			else 
			{
				// No user exists. 
				return false;
			}
		}
	}//function loginProcess($email, $password)

	static function checkBrute($user_id) 
	{
		global $mysqli;
		// Get timestamp of current time
		$now = time();
		// All login attempts are counted from the past 2 hours. 
		$valid_attempts = $now - (2 * 60 * 60); 
 
		if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) 
		{ 
			$stmt->bind_param('i', $user_id); 
			// Execute the prepared query.
			$stmt->execute();
			$stmt->store_result();
			// If there has been more than 5 failed logins
			if($stmt->num_rows > 5) 
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}//function checkBrute($user_id)

	static function loginCheck() 
	{
		global $mysqli;
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) 
		{
			$user_id = $_SESSION['user_id'];
			$login_string = $_SESSION['login_string'];
			$username = $_SESSION['username'];
 
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
			if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) 
			{ 
				$stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
				$stmt->execute(); // Execute the prepared query.
				$stmt->store_result();
 
				if($stmt->num_rows == 1) 
				{ // If the user exists
					$stmt->bind_result($password); // get variables from result.
					$stmt->fetch();
					$login_check = hash('sha512', $password.$user_browser);
					if($login_check == $login_string) 
					{
						// Logged In!!!!
						return true;
					} 
					else 
					{
						// Not logged in
						return false;
					}
				} 
				else 
				{
					// Not logged in
					return false;
				}
			} 
			else 
			{
				// Not logged in
				return false;
			}
		} 
		else 
		{
			// Not logged in
			return false;
		}
	}//function login_check()

}//class Login

?>