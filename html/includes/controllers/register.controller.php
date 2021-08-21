<?php

/* This controller renders the register page */

class RegisterController
{
	public function handleRequest()
	{
		if(isset($_POST['username'], $_POST['name'], $_POST['last_name'], $_POST['gender'], $_POST['country'], $_POST['timezone'], $_POST['email'], $_POST['p'])) 
		{ 
			$username = $_POST['username'];
	
			$name = $_POST['name'];
	
			$last_name = $_POST['last_name'];
			
			$gender = $_POST['gender'];
	
			$country = $_POST['country'];
			
			$timezone = $_POST['timezone'];
			
			$dst = isset($_POST['DST']) ? 1 : 0;
	
			$email = $_POST['email'];
	
			$password = $_POST['p']; // The hashed password.
	
			if(Register::addUser($username, $name, $last_name, $gender, $country, $timezone, $dst, $email, $password) == true) 
			{
				// user account created
				render('message',array('title'=>'Account created!',
				   'body' => 'Success: Your account have been created!', 'register'=>true));
			} 
			else 
			{
				// submit failed
				render('message',array('title'=>'Account not created!',
				   'body' => 'There was an error creating your account!', 'register'=>true));
			}
		}
		else 
		{
			$countries = getCountries();
			$timezones = Timezone::getZones();
			render('register', array('title' => 'Register', 'register'=>true, 'countries'=>$countries,'timezones'=>$timezones));
		} 
		
	}
}

?>