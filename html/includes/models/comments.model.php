<?php

class Comments
{
	public $num = 0;
	
	// add comment
	static function addComment($content)
	{
		global $mysqli;
		
		$currentComment = new Comment();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['post_id'],$_SESSION['commenter_id'],$_SESSION['commented_id'])) 
		{
			$user_id = $_SESSION['commented_id'];
			$post_id = $_SESSION['post_id'];
			$commenter_id = $_SESSION['commenter_id'];
			
			//local time
			$timezone = $_SESSION['timezone'];
			$dst = $_SESSION['dst'];

			$localDate = Timezones::GetTime($timezone, $dst);
			
			if ($insert_stmt = $mysqli->prepare("INSERT INTO comments (post_id,user_id,commenter_id,body,created,modified) VALUES (?, ?, ?, ?, ?, ?)")) 
			{    
				$insert_stmt->bind_param('iiisss', $post_id, $user_id, $commenter_id, $content, $localDate, $localDate); 
				// Execute the prepared query.
				$insert_stmt->execute();
				return true;
			}
		}
		else { return false; }				
	}//function addComment($content)
	
	// delete comment
	function delComment($id)
	{
		global $mysqli;
		
		$currentComment = new Comment();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'],$_SESSION['post_id'])) 
		{
			//$id = $_SESSION['comment_id'];
			$user_id = $_SESSION['user_id'];
			$post_id = $_SESSION['post_id'];
			$visitor = $_SESSION['visitor'];
			
			if ($stmt = $mysqli->prepare("DELETE FROM comments WHERE id = ? AND user_id = ? AND post_id = ?")) 
			{ 
				$stmt->bind_param('iii', $id, $user_id, $post_id);
				
				try
				{
					//commit to database with transactions
					/* set autocommit to off */
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
	}//function deleteComment()

	// get comments of current post
	function getComments()
	{
		global $mysqli;
		global $site;
		global $meminstance;
		global $timeout;
		
		$comments = array();
		$currentComment = new Comment();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'],$_SESSION['post_id'],$_SESSION['commented_id'])) 
		{
			$user_id = $_SESSION['commented_id'];
			$post_id = $_SESSION['post_id'];
						
			//frist we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our comments data
				$key = $user_id.'_COMMENT_POSTID_'.$post_id;
 
				// Now we get the data from our cache server
				$comments = getCache($key);
				if($comments)
				{
					$num_rows = count($comments);
					$this->num = $num_rows;
					return $comments;
				}
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$comments)
			{
				if ($stmt = $mysqli->prepare("SELECT username as commenterName,comments.id as id,user_id,post_id,body,created,modified FROM comments, members WHERE user_id = ? AND comments.commenter_id=members.id AND post_id = ?")) 
				{ 
					$stmt->bind_param('ii', $user_id, $post_id);
					$stmt->execute(); // Execute the prepared query.
					$stmt->store_result();
					$num_rows = $stmt->num_rows;
				
					$this->num = $num_rows;
					
					//if we found all the comments
					if($num_rows > 0) 
					{
						$meta = $stmt->result_metadata();
						$parameters = array();
						while ($field = $meta->fetch_field()) 
						{
							$columns[] = &$row[$field->name]; 
						}
						mysqli_free_result($meta);
						call_user_func_array(array($stmt, 'bind_result'), $columns);
					
						while ($stmt->fetch()) 
						{ 
							foreach($row as $key => $val) 
							{
								$currentComment->$key = $val;
								$_date = explode('-', $currentComment->created);
								$_year = $_date[0];
								$_month = $_date[1];
								$tmp = explode(' ', $_date[2]);
								$_day = $tmp[0]; 
								//$currentComment->url = $site.'comment/view/'.$_year.'/'.$_month.'/'.$_day;
								$currentComment->del_url = $site.'comment/del/'.$currentComment->id;
							} 
							$comments[] = $currentComment;
							$currentComment = new Comment(); 
						}
						//memcache comments of current post
						setCache($user_id.'_COMMENT_POSTID_'.$post_id, $comments, $timeout);
						return $comments;
					}	
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return -1; }				
		return false;
	}//function getComments()
	
}//class Comments

?>