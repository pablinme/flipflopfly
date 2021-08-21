<?php

class Register
{
	static function addUser($username, $name, $last_name, $gender, $country, $timezone, $dst, $question, $answer, $email, $password)
	{
		global $mysqli;
		
		if($username == '' ||  $name == '' || $last_name == '' || $gender == '' || $country == '' || $question == '' || $answer == '' || $email == '' || $password == '')
			return false;
		
		// Create a random salt
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

		// Create salted password (Careful not to over season)
		$password = hash('sha512', $password.$random_salt);
 
		if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, name, last_name, gender, country, timezone, dst, email, join_date, password, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?, ?)")) 
		{    
			$insert_stmt->bind_param('sssssiisss', $username, $name, $last_name, $gender, $country, $timezone, $dst, $question, $answer, $email, $password, $random_salt); 
			// Execute the prepared query.
			$insert_stmt->execute();
			return true;
		}
	}//function addUser($username, $name, $last_name, $country, $question, $answer, $email, $password)

	static function removeUser($username,$email)
	{
		global $mysqli;
		if ($insert_stmt = $mysqli->prepare("DELETE FROM members WHERE username = ? and email = ?")) 
		{    
			$insert_stmt->bind_param('ss', $username, $email); 
			// Execute the prepared query.
			$insert_stmt->execute();
			return true;
		}
	}//function removeUser($username,$email)
}

?>