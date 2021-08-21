<?php

/* This controller routes users requests */

class UsersController
{
	public function handleRequest()
	{
		//view other user's profile
		//switch(URI_PART_1) 
		//{			
			//case 'view':
				if(Login::loginCheck() == true) 
				{
					//check if user exists
					$user = URI_PART_1;
					if($user != 'URI_PART_1')
					{
						 
						Users::setVisitor();
						if(Users::exists($user))
						{
							// protected content!
							global $limitLatest;
							$username = $_SESSION['username'];
							$ownerUsername = $_SESSION['profile_username'];
							
							if(isset($_GET['page'])) $page = $_GET['page'];
							else if(!is_int($page)) $page = 0;
							else if($page < 1) $page = 0;
							else $page = 0;
							
							$_posts = new Posts();			
							$posts = $_posts->getPosts($page);
			
							$numPosts = $_posts->num;
							$pagination = $_posts->hasPagination($page);
			
							/* Sidebar contents */
							$sidebar = new Sidebar();
							
							render('home_reg',array(
								   'title' => 'Chasqui',
								   'page' => $page,
								   'posts' => $posts,
								   'numPosts' => $numPosts,
								   'pagination' => $pagination,
								   'home'=>true,
								   'head'=>'profile of user: '.$ownerUsername,
								   'sidebar'=>$sidebar,
								   'username' => $username,
								   'ownerUsername' => $ownerUsername,
								   'visitor' => true
								));
							 
						}
					}					
				}
			//break;
			
		//}
	}
}

?>