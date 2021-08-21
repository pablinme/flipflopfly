<?php

/* This controller renders the login page */

class LoginController
{
	public function handleRequest()
	{
		global $site;

		if(isset($_POST['email'], $_POST['p'])) 
		{ 
			$email = $_POST['email'];
			$password = $_POST['p']; // The hashed password.
			if(Login::loginProcess($email, $password) == true) 
			{
				// Login success
				header('Location: '.$site);
			} 
			else 
			{
				// Login failed
				render('message',array('title'=>'Error en login',
				   'body' => 'You have not been logged in!'));
				
				//header('Location: ./?error');
			}
		} 
		else 
		{ 
			render('login',array('title' => 'Login', 'login'=>true));
		}		
	}
}


?>