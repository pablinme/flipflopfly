<?php

/* This controller routes ajax requests */

class AjaxController
{
	public function handleRequest()
	{
		global $site;
		//ajax handler
		switch(URI_PART_1) 
		{
			case 'check':
				include DIR_MODUP.'/ajax/checkData.php';
				//header('Location: '.$site);
			break;
			
			case 'topic':
				if(Login::loginCheck() == true) 
				{
					if(URI_PART_2 == 'add')
					{
						include DIR_MODUP.'/ajax/addTopic.php';
					}
				}
			break;
			
			case 'post':
				if(Login::loginCheck() == true) 
				{
					if(URI_PART_2 == 'add')
					{
						include DIR_MODUP.'/ajax/addPost.php';
					}
				}
			break;
			
			case 'comment':
				if(Login::loginCheck() == true) 
				{
					if(URI_PART_2 == 'add')
					{
						include DIR_MODUP.'/ajax/addComment.php';
					}
					if(URI_PART_2 == 'del')
					{
						include DIR_MODUP.'/ajax/delComment.php';
					}
				}
			break;
			
			case 'rating':
				include DIR_MODUP.'/ajax/rating.php';
				//header('Location: '.$site);
			break;
		}
		
	}
}

?>