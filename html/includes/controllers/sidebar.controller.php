<?php

/* This controller renders the login page */

class LoginController
{
	public function handleRequest()
	{
		global $site;
		//$session = new session();
		// Set to true if using https
		//$session->start_session('_s', false);

		if(isset($_POST['email'], $_POST['p'])) 
		{ 
			$email = $_POST['email'];
			$password = $_POST['p']; // The hashed password.
			if(Login::loginProcess($email, $password) == true) 
			{
				// Login success
				//echo 'Success: You have been logged in!';
				header('Location: '.$site);
			} 
			else 
			{
				// Login failed
				render('message',array('title'=>'Error en login',
				   'body' => 'You have not been logged in!'));
				
				//header('Location: ./index.php?error=1');
			}
		} 
		else 
		{ 
			render('login',array('title' => 'Login', 'login'=>true));
		}		
	}
}


?>