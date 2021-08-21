<?php

class Posts
{
	public $num = 0;
	
	// add single post
	static function addPost($content, $topic)
	{
		global $mysqli;
		global $timeout;

		$currentPost = new Post();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			//local time
			$timezone = $main_timezone;
			$dst = $main_dst;
			
			$localDate = Timezones::GetTime($timezone, $dst);
			
			if ($insert_stmt = $mysqli->prepare("INSERT INTO posts (content,date,local_date,topic,user_id) VALUES (?, now(), ?, ?, ?)")) 
			{    
				$insert_stmt->bind_param('ssii', $content, $localDate, $topic, $user_id); 
				// Execute the prepared query.
				$insert_stmt->execute();
				return true;
			}
		}
		else { return false; }				
	}//function addPost($title, $content)
	
	// delete single post
	function deletePost($topic, $post)
	{
		global $mysqli;
		
		$currentPost = new Post();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			
			if ($stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ? AND user_id = ? AND topic = ?")) 
			{ 
				$stmt->bind_param('iii', $post, $user_id, $topic);
				
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
	}//function deletePost($year, $month, $day, $title)

	// Helper function to determine whether
	// to show the pagination buttons
	function hasPagination($page, $topicID)
	{
		global $mysqli;
		global $postsPage;
		$response = array();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];	
			$limit = $postsPage;
			
			if($page == 0) 
			{
				$limit = $limit + 1; 
				$offset =  ($limit * $page);
			}
			else $offset = $limit * ($page + 1);
			
			if ($stmt = $mysqli->prepare("SELECT content, date FROM posts WHERE topic = ? ORDER BY date asc LIMIT ?, ?")) 
			{ 
				$stmt->bind_param('iii', $topicID, $offset, $limit);
				$stmt->execute(); // Execute the prepared query.
				$stmt->store_result();
				$num_rows = $stmt->num_rows;
			
				if($page == 0 && ($num_rows < $limit)) $num_rows = 0;
			
				try
				{
					$response = array('prev'=> $page > 0,
					'next'=> $num_rows > 0
					);  
					return $response; 
				
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
	
	}//hasPagination($page, $topicID)
	
	//get posts by page and offset
	function getPosts($page, $topicID)
	{
		global $postsPage;
		global $mysqli;
		global $site;
		
		$posts = array();
		$currentPost = new Post();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];

			$offset = $postsPage * $page;
	
			if ($stmt = $mysqli->prepare("SELECT username as posterName, content, locaL_date as date FROM posts, members WHERE topic = ? AND posts.user_id=members.id ORDER BY date asc LIMIT ?, ?")) 
			{ 
				$stmt->bind_param('iii', $topicID, $offset, $postsPage); // Bind "$user_id" to parameter.
				$stmt->execute(); // Execute the prepared query.
				$stmt->store_result();
				$num_rows = $stmt->num_rows;
			
				$this->num = $num_rows;
			 
				//if the user has at least one post
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
							$currentPost->$key = $val;
							//$currentPost->url = $site.'post/view/'.$_year.'/'.$_month.'/'.$_day.'/'.$name;
							//$currentPost->del_url = $site.'post/del/'.$_year.'/'.$_month.'/'.$_day.'/'.$name;
						} 
						$posts[] = $currentPost;
						$currentPost = new Post(); 
					}
					return $posts;
				}
				else { return $mysqli->error; }
			}
		}
		else { return -1; }			
	}//function getPosts($page, $topicID)

}//class Posts

?>