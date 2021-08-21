<?php
class Requests
{
	//variables
	var $latest = array();
	var $userInfo = array();
	
	//constructor
	function __construct()
	{
		$this->latest = self::getLatest();
	}
	
	//get latest requests
	function getLatest()
	{
		global $mysqli;
		global $site;
		global $meminstance;
		global $timeout;
		global $limitRequests;
		
		$topics = array();
		$currentTopic = new Topic();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			$username = $_SESSION['username'];
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
			
			$offset = $limitLatest * $page;
			
			//frist we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our product data
				$key = '_TOPIC_LATEST_'.$limitLatest;
 
				// Now we get the data from our cache server
				$topics = getCache($key);
				if($topics)
				{
					$num_rows = count($topics);
					$this->numTopics = $num_rows;
					return $topics;
				}
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$topics)
			{
				if ($stmt = $mysqli->prepare("SELECT username as posterName, subject, date, category, topics.id FROM topics, members WHERE user_id != ? AND user_id=members.id ORDER BY date desc LIMIT ?, ?")) 
				{ 
					$stmt->bind_param('iii', $user_id, $offset, $limitLatest); // Bind "$user_id" to parameter.
					$stmt->execute(); // Execute the prepared query.
					$stmt->store_result();
					$num_rows = $stmt->num_rows;
				
					$this->numTopics = $num_rows;
				 
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
								if($key == 'id') $currentTopic->url = $site.'category/'.$cat.'/'.$val; 
							} 
							$topics[] = $currentTopic;
							$currentTopic = new Topic(); 
						}
						//memcache latestposts
						setCache('_TOPIC_LATEST_'.$limitLatest, $topics, $timeout);  
						return $topics;
					}
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return -1; }			
	}//function getLatest($numLatest)

	//get user info for the badge 
	function getUserInfo()
	{
		global $mysqli;
		global $site;
		global $meminstance;
		global $timeout;
		
		$user = new User();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'])) 
		{
			$user_id = $_SESSION['user_id'];
			$username = $_SESSION['username'];
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
						
			//first we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our product data
				$key = $user_id.'_INFO_';
 
				// Now we get the data from our cache server
				$response = getCache($key);
				if($response) { return $response; }
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$response)
			{
				if ($stmt = $mysqli->prepare("SELECT username, name, last_name as lastname, gender, countryName as country, join_date as date FROM members, countries WHERE members.id = ? AND country=countryCode LIMIT 1")) 
				{ 
					$stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
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
								if($key == 'gender') $val = ($val == 'M') ? 'male' : 'female';
								if($key == 'date')
								{
									$new = explode(" ", $val);
									$val = $new[0];
								}
								$user->$key = $val;
							} 
						}
						//memcache latestposts
						setCache($user_id.'_INFO_', $user, $timeout);  
						return $user;
					}
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return -1; }			
	}//function getUserInfo()

		
}//class Requests
?>
