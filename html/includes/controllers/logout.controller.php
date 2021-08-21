<?php

/* This controller logs out the user */

class LogoutController
{
	public function handleRequest()
	{
		global $site;
		//$session = new session();
		// Set to true if using https
		//$session->start_session('_s', false);

		$_SESSION = array();
		// get session parameters 
		$params = session_get_cookie_params();
		
		// Delete the actual cookie.
		setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

		// Destroy session
		session_destroy();
		header('Location: '.$site);
	}
}


?>