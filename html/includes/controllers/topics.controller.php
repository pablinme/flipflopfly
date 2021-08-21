<?php

class TopicsController
{
	public function handleRequest()
	{
		if(Login::loginCheck() == true) 
		{
			global $limitLatest;
			$category = URI_PART_1;
			
			$categoryID = ($category == 'request') ? 1 : 2;
			 	
			$username = $_SESSION['username'];

			if(isset($_GET['page'])) $page = $_GET['page'];
			else if(!is_int($page)) $page = 0;
			else if($page < 1) $page = 0;
			else $page = 0;
			
			$_topics = new Topics();
				
			$topics = $_topics->getTopics($page, $categoryID); 
					
			$pagination = $_topics->hasPagination($page, $categoryID);
			
			$numTopics = $_topics->num;
				
			/* Sidebar contents */
			//user -- topics -- ratings
			//$sidebar = new Sidebar(true, false, true);
			
			/* Breadcrumbs contents */
			$breadcrumbs = getBreadcrumbs();
												
			render('topics',array(
				   'title' => 'Chasqui',
				   'header' => true,
				   'footer' => true,
				   'page' => $page,
				   'topics' => $topics,
				   'numTopics' => $numTopics,
				   'pagination' => $pagination,
				   'username' => $username,
				   'sidebar' => $sidebar,
				   'category' => $categoryID,
				   'breadcrumbs' => $breadcrumbs
				  ));

		}
		else
		{
			render('login',array('title' => 'Login', 'login'=>true));
		}	
	}//function
}//class
?>