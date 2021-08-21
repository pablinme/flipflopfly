<?php
/* This controller renders the home page */
class HomeController
{
	public function handleRequest()
	{
		if(Login::loginCheck() == true) 
		{
			// protected content!
			Users::backHome();
			
			$username = $_SESSION['username'];
			$timezone = $_SESSION['timezone'];
			$dst = $_SESSION['dst'];
			
			//local time
			$time = Timezones::GetTime($timezone, $dst);

			/* Sidebar contents */ 
			//user -- topics -- ratings
			//$sidebar = new Sidebar(true, true, true);
			
			/* Breadcrumbs contents */
			$parts = URI_PARTS;
			
			$breadcrumbs = getBreadcrumbs($parts);
			
			render('home_reg',array(
				   'title' => 'Chasqui',
				   'head'=>'welcome '.$username,
				   'sidebar'=>$sidebar,
				   'username' => $username,
				   'time' => $time,
				   'breadcrumbs' => $breadcrumbs
				  ));				  
		} 
		else 
		{
			//request
			//$requests = new Requests();
			
			//offers
			
			 
			render('home_new',array( 'title' => 'Welcome to Flipflopfly', 'home'=>true, 'head'=>'Welcome')); 
		}
	}
}
?>