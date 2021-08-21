<?php

class CommentsController
{
	public function handleRequest()
	{
		if(Login::loginCheck() == true) 
		{
			//action (add|view|delete)
			switch(URI_PART_1) 
			{
				case 'add':
				break;
				
				case 'view':
				$year = URI_PART_2;
				$month = URI_PART_3;
				$day = URI_PART_4;
				
				global $limitLatest;
				$username = $_SESSION['username'];
				
				if(isset($_GET['page'])) $page = $_GET['page'];
				else if(!is_int($page)) $page = 0;
				else if($page < 1) $page = 0;
				else $page = 0;
			
				$_comments = new Comments();
				
				/* Sidebar contents */
				//user -- topics -- ratings
				$sidebar = new Sidebar(true, false, true);
							
				// year - month - day - name 
				if($year != 'URI_PART_2' && is_numeric($year) &&
				   $month != 'URI_PART_3' && is_numeric($month) &&
				   $day != 'URI_PART_4' && is_numeric($day))
				{
					$comments = $_comments->getComments($year, $month, $day); //single comment view
				}	
				/*
				else if($year != 'URI_PART_2' && is_numeric($year) &&
						$month == 'URI_PART_3'&& $day == 'URI_PART_4') // year
				{
					$comments = $_comments->getCommentsByYear($year, $page);
				}
				else if($year != 'URI_PART_2' && is_numeric($year) && 
						$month != 'URI_PART_3' && is_numeric($month) &&
						$day == 'URI_PART_4') // year - month 
				{
					$comments = $_comments->getCommentsByMonth($year, $month, $page);
				}
				else if($year != 'URI_PART_2' && is_numeric($year) && 
						$month != 'URI_PART_3' && is_numeric($month) &&
						$day != 'URI_PART_4' && is_numeric($day)) // year - month - day 
				{
					$comments = $_comments->getCommentsByDay($year, $month, $day, $page);
				}
				*/
				else
				{
					render('message_reg',array('title'=>'Chasqui',
											   'alertShow'=>true,
											   'body' => 'page not found!',
											   'username' => $username,
											   'sidebar'=>$sidebar));
				   break;
				}	
				$numComments = $_comments->num;

				render('comments',array(
					   'title' => 'Chasqui',
					   'header' => true,
					   'footer' => true,
					   'comments' => $comments,
					   'numComments' => $numComments,
					   'username' => $username,
					   'sidebar'=>$sidebar));
				
				
				break;
				
				case 'del':
				$year = URI_PART_2;
				$month = URI_PART_3;
				$day = URI_PART_4;
				
				global $limitLatest;
				$_comments = new Comments();
				
				/* Sidebar contents */
				$sidebar = new Sidebar();
											
				if($year != 'URI_PART_2' && is_numeric($year) && 
				   $month != 'URI_PART_3' && is_numeric($month) &&
				   $day != 'URI_PART_4' && is_numeric($day))
				{
					$_comments->deleteComment($year, $month, $day);
					render('message_reg',array('title'=>'Chasqui',
											   'body' => 'comment deleted!',
											   'alertShow'=>true,
											   'username' => $username,
											   'sidebar'=>$sidebar));
				}
				else
				{
					render('message_reg',array('title'=>'Chasqui',
											   'alertShow'=>true,
											   'body' => 'request not valid!',
											   'username' => $username,
											   'sidebar'=>$sidebar));
				}	
				break;
				
				//case 'edit':
				//break;
				
				case 'update':
				break;
				
				default:
				global  $site;
				header('Location: '.$site);
				break;
			}//switch		
		}//if(Login::login_check() == true) 

		else
		{
			render('login',array('title' => 'Login', 'login'=>true));
		}	
	}//function
}//class


?>