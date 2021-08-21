<?php
	
	if(isset($_POST['comment']))
	{
		$id = rtrim(ltrim($_POST['comment']));
		
		if(Comments::delComment($id)) echo 1;
		else echo 0;
	}
	else echo 0;
?>