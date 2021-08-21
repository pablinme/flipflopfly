<?php
	$category = URI_PART_1;
	if($category == 'request' || $category == 'help')
	{
		//we check the value and get all posts of this topic
		$topic = URI_PART_2;
		if($topic != 'URI_PART_2')
		{
			$c = new PostsController();
			$c->handleRequest($topic);
		}
		else
		{	
			$c = new TopicsController();
			$c->handleRequest();
		}
	}
	else
	{
		$c = new HomeController();
		$c->handleRequest();
	}
?>
