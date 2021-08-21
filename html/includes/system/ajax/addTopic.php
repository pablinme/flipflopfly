<?php
	if(isset($_POST['subject'], $_POST['category']))
	{
		$subject = rtrim(ltrim($_POST['subject']));
		$category = rtrim(ltrim($_POST['category']));
			
		if(Topics::addTopic($subject, $category)) echo 1;
		else echo 0;
	}
	else echo 0;
?>