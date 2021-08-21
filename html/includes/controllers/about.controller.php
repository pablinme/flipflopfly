<?php

/* This controller routes users requests */

class AboutController
{
	public function handleRequest()
	{
		if(Login::loginCheck() == true) 
		{
			$username = $_SESSION['username'];
			render('about_reg',array(
				'title' => 'Flipflopfly',
				'about'=>true,
				'username'=>$username,
				'head'=>'About Us'		
			));
		}
		else
		{
			render('about',array(
				'title' => 'Flipflopfly',
				'about'=>true,
				'head'=>'About Us'		
			));
		}
	}
}

?>