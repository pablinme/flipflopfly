<?php

class Rates
{
	public $num = 0;
		
	// rate a user
	static function addRate($value)
	{
		global $mysqli;
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['rated_id'], $_SESSION['rater_id'])) 
		{
			$rater = $_SESSION['rater_id'];
			$rated = $_SESSION['rated_id'];

			if($insert_stmt = $mysqli->prepare("INSERT INTO ratings (total,raterId,ratedId,date) VALUES (?, ?, ?, now())")) 
			{    
				$insert_stmt->bind_param('iii', $value, $rater, $rated); 
				// Execute the prepared query.
				$insert_stmt->execute();
				return true;
			}
		}
		else { return false; }				
	}//function addRate($value)
	
}//class Rates

?>