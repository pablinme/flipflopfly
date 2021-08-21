<?php

class PostsController
{
	public function handleRequest($topic)
	{
		if(Login::loginCheck() == true) 
		{
			global $limitLatest;
			$username = $_SESSION['username'];

			if(isset($_GET['page'])) $page = $_GET['page'];
			else if(!is_int($page)) $page = 0;
			else if($page < 1) $page = 0;
			else $page = 0;
			
			//get topic id
			$topicID = Topics::getID($topic);
			$_posts = new Posts();
				
			$posts = $_posts->getPosts($page, $topicID); 
					
			$pagination = $_posts->hasPagination($page, $topicID);
			
			$numPosts = $_posts->num;
					
			/* Sidebar contents */
			//user -- topics -- ratings
			//$sidebar = new Sidebar(true, false, true);
			
			/* Breadcrumbs contents */
			$breadcrumbs = getBreadcrumbs();
			
			render('posts',array(
				   'title' => 'Chasqui',
				   'header' => true,
				   'footer' => true,
				   'page' => $page,
				   'posts' => $posts,
				   'numPosts' => $numPosts,
				   'pagination' => $pagination,
				   'username' => $username,
				   'sidebar' => $sidebar,
				   'topic' => $topic,
				   'topicID' => $topicID,
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