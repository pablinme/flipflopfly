<?php

class Users
{
	//set visitor variables
	static function setVisitor()
	{
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			$_SESSION['visitor_id'] = $user_id;
			$_SESSION['rater_id'] = $user_id;
			$_SESSION['visitor'] = true;
		}
	}//function setVisitor()
	
	static function backHome()
	{
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			$_SESSION['rater_id'] = $user_id; //user that commits the rate
			$_SESSION['rated_id'] = $user_id; //user that recieves the rate
			
			$_SESSION['profile_username'] = $_SESSION['username'];
			$_SESSION['profile_id'] = $user_id;
			$_SESSION['visitor'] = false;
		}
	}//function backHome()
	
	// check if user exits
	static function exists($user)
	{
		global $mysqli;
		
		// Check if all session variables are set
		if(isset($_SESSION['visitor_id'], $_SESSION['username'],$_SESSION['rater_id'])) 
		{
			if ($stmt = $mysqli->prepare("SELECT id,username FROM members WHERE username = ?")) 
			{    
				$stmt->bind_param('s', $user); 
				$stmt->execute(); // Execute the prepared query.
				$stmt->store_result();
				$stmt->bind_result($user_id, $user_name); // get variable from result.
				$stmt->fetch();
				
				if($stmt->num_rows == 1)
				{
					$_SESSION['profile_id'] = $user_id;
					$_SESSION['profile_username'] = $user_name;
					$_SESSION['rated_id'] = $user_id;
					return true;
				}
				else { return false; } 
			}
			else { return false; }
		}
		else { return false; }				
	}//function exists($user)
	
	// delete user
	/*
	function deleteUser()
	{
		global $mysqli;
		
		$currentComment = new Comment();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			$username = $_SESSION['username'];
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
			$post_id = $_SESSION['post_id'];
			$id = $_SESSION['comment_id'];
			$modified = $_SESSION['comment_modified'];
			
			if ($stmt = $mysqli->prepare("DELETE FROM comments WHERE id = ? AND user_id = ? AND post_id = ? AND modified = ?")) 
			{ 
				$stmt->bind_param('iiis', $id, $user_id, $post_id, $modified);
				
				try
				{
					//commit to database with transactions
					// set autocommit to off 
					$mysqli->autocommit(FALSE);
					$stmt->execute(); // Execute the prepared query.
				
					if($stmt->affected_rows == 1) 
					{
						$mysqli->commit();;
						return true;
					}
					else 
					{
						$mysqli->close();
						return false;
					}
				}
				catch(Exception $e )
				{
					echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
					echo nl2br($e->getTraceAsString());
				}	
			}
			else { return $mysqli->error; }
		}
		else { return false; }				
	}//function deleteUser()
	*/
	
}//class Users

?>