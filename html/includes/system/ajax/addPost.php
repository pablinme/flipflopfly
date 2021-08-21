<?php
	
	if(isset($_POST['content'], $_POST['topic']))
	{
		$content = rtrim(ltrim($_POST['content']));
		$topic = rtrim(ltrim($_POST['topic']));
		
		if(Posts::addPost($content, $topic)) echo 1;
		else echo 0;
	}
	else echo 0;
?>