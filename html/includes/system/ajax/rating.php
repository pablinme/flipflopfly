<?php
	if(isset($_POST['num']))
	{
		global  $units;		
		$num = (int)rtrim(ltrim($_POST['num']));
		
		if($num <= $units) 
		{
			if(Rates::addRate($num)) echo 1;
			else echo 0;	
		}
		else echo 0;
	}
	else echo 0;
?>
