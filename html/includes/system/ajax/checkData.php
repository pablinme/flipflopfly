<?php
	if(isset($_POST['username']) || isset($_POST['email']))
	{
		if(isset($_POST['username']))
		{
			$username = trim($_POST['username']);
			if(checkData('user', $username)) echo 1;
			else echo 0;
		}
		else if(isset($_POST['email']))
		{
			$email = trim($_POST['email']);
			if(checkData('email', $email)) echo 1;
			else echo 0;
		}
	}
?>