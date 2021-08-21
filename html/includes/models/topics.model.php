<?php

class Topics
{
	public $num = 0;
	
	//get topic id
	static function getID($topic)
	{
		global $mysqli;
		global $meminstance;
		global $timeout;
		$id;
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];	
			$response = array();
			
			//first we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our product data
				$key = 'topicIDByName'.$topic;
 
				// Now we get the data from our cache server
				$response = getCache($key);
				if($response) { return $response; }
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$response)
			{
				if ($stmt = $mysqli->prepare("SELECT id FROM topics WHERE name = ? LIMIT 1")) 
				{ 
					$stmt->bind_param('s', $topic);
					$stmt->execute(); // Execute the prepared query.
					$stmt->store_result();
					$num_rows = $stmt->num_rows;
								
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
								if($key == 'id') $id = $val;
							}  
						}
						//memcache topicIDByName
						setCache('topicIDByName'.$topic, $id, $timeout); 
						return $id;
					}
	
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return false; }
	}//getName($topicID)
	
	// add single topic
	static function addTopic($subject, $category)
	{
		global $mysqli;
		global $timeout;
		
		$currentTopic = new Topic();

		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];

			//local time
			$timezone = $_SESSION['timezone'];
			$dst = $_SESSION['dst'];
			
			$localDate = Timezones::GetTime($timezone, $dst);
			$name = clean($subject);
			if ($insert_stmt = $mysqli->prepare("INSERT INTO topics (name,subject,date, local_date,category,user_id) VALUES (?, ?, now(), ?, ?, ?)")) 
			{    
				$insert_stmt->bind_param('sssii', $name, $subject, $localDate, $category, $user_id); 
				// Execute the prepared query.
				$insert_stmt->execute();
				
				return true;
			}
		}
		else { return false; }				
	}//function addTopic($subject, $category)
	
	// delete single topic
	function deleteTopic()
	{
		global $mysqli;
		
		$currentPost = new Post();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'],$_SESSION['post_id'])) 
		{
			$user_id = $_SESSION['user_id'];
			$id = $_SESSION['post_id'];
			
			if ($stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?")) 
			{ 
				$stmt->bind_param('ii', $id, $user_id);
				
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
	function hasPagination($page, $category)
	{
		global $mysqli;
		global $topicsPage;
		global $meminstance;
		global $timeout;
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];	
			$limit = $topicsPage;
			$response = array();
			
			if($page == 0) 
			{
				$limit = $limit + 1; 
				$offset =  ($limit * $page);
			}
			else $offset = $limit * ($page + 1);
			
			//first we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our product data
				$key = '_TOPIC_PAGINATION_PAGE'.$category.'_'.$page;
 
				// Now we get the data from our cache server
				$response = getCache($key);
				if($response) { return $response; }
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$response)
			{
				if ($stmt = $mysqli->prepare("SELECT category FROM topics WHERE category = ? ORDER BY date desc LIMIT ?, ?")) 
				{ 
					$stmt->bind_param('iii', $category, $offset, $limit);
					$stmt->execute(); // Execute the prepared query.
					$stmt->store_result();
					$num_rows = $stmt->num_rows;
				
					if($page == 0 && ($num_rows < $limit)) $num_rows = 0;
				
					try
					{
						$response = array('prev'=> $page > 0,
						'next'=> $num_rows > 0
						);
						//memcache lID_PAGINATION_PAGE_OFFSET
						setCache('_TOPIC_PAGINATION_PAGE'.$category.'_'.$page, $response, $timeout);  
						return $response; 
					
					}
					catch(Exception $e )
					{
						echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
						echo nl2br($e->getTraceAsString());
					}	
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return false; }				
		
	}//hasPagination($page = 1)
	
	//get topics by page, category and offset
	function getTopics($page, $category)
	{
		global $topicsPage;
		global $mysqli;
		global $site;
		global $meminstance;
		global $timeout;
		
		$topics = array();
		$currentTopic = new Topic();
		$cat = ($category == '1') ? 'request' : 'help';
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];

			$offset = $topicsPage * $page;
	
			//frist we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our posts data
				$key = $category.'_TOPIC_PAGE_'.$page;
				
				// Now we get the data from our cache server
				$topics = getCache($key);
				if($topics)
				{
					$num_rows = count($topics);
					$this->num = $num_rows;
					return $topics;
				}
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$topics)
			{			
				if ($stmt = $mysqli->prepare("SELECT username as posterName, topics.name, subject, local_date as date, category, topics.id FROM topics, members WHERE category = ? AND user_id=members.id ORDER BY date desc LIMIT ?, ?")) 
				{ 
					$stmt->bind_param('iii', $category, $offset, $topicsPage);
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
								$currentTopic->$key = $val;
								if($key == 'name') $currentTopic->url = $site.'category/'.$cat.'/'.$val;
							} 
							$topics[] = $currentTopic;
							$currentTopic = new Topic(); 
						}
						//memcache posts_page_x
						setCache($category.'_TOPIC_PAGE_'.$page, $topics, $timeout); 
						return $topics;
					}
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return -1; }			
	}//function getTopics($page, $category)

}//class Topics

?>