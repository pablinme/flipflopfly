<?php
	
	if(isset($_POST['content']))
	{
		$content = rtrim(ltrim($_POST['content']));
		
		if(Comments::addComment($content)) echo 1;
		else echo 0;
	}
	else echo 0;
?>