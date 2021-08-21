<?php
class Sidebar
{
	//variables
	var $latestTopics = array(); //array of topics
	var $numTopics; //int (number of topics)
	var $titleTopics;
	var $latestRates = array(); //array of rates
	var $numRates; //int (number of rates)
	var $titleRates;
	var $userInfo = array();
	
	//constructor
	public function __construct($showUser, $showTopics, $showRating)
	{
		/* User Info*/
		if($showUser)
		{
			$this->userInfo = self::getUserInfo();
		}
		if($showTopics)
		{
			/* Latest Topics */
			$this->titleTopics = 'Latest Topics';
			$this->latestTopics = self::getLatestTopics();
		}
		if($showRating)
		{	
			/* Rating System */
			$this->titleRates = 'Latest Rates';
			$this->latestRates = self::getLatestRates();
		}
	}
	
	//get user info for sidebar 
	public function getUserInfo()
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

	//get latest topics for sidebar
	public function getLatestTopics()
	{
		global $mysqli;
		global $site;
		global $meminstance;
		global $timeout;
		global $limitLatest;
		
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
	}//function getLatestTopic($numLatest)
	
	//get latest rates for sidebar
	public function getLatestRates()
	{
		global $mysqli;
		global $meminstance;
		global $timeout;
		global $limitLatest;
		
		$rates = array();
		$currentRate = new Rate();
		
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['rated_id'])) 
		{
			$user_id = $_SESSION['rated_id'];

			$offset = 0;
			
			//frist we check if memcache is set
			if ($meminstance == true)
			{
				// We build the key we associated to our product data
				$key = $user_id.'_RATING_LATEST_'.$limitLatest;
 
				// Now we get the data from our cache server
				$rates = getCache($key);
				if($rates)
				{
					$num_rows = count($rates);
					$this->numRates = $num_rows;
					return $rates;
				}
			}

			//if we do not have a value on cache, we fetch from db and then sava it to cache
			if (!$rates)
			{
				if ($stmt = $mysqli->prepare("SELECT username as raterName, ratings.id, total, raterId, ratedId, ratings.date FROM ratings, members WHERE ratedId = ? AND ratings.raterId=members.id ORDER BY date desc LIMIT ?, ?")) 
				{ 
					$stmt->bind_param('iii', $user_id, $offset, $limitLatest); 
					$stmt->execute(); // Execute the prepared query.
					$stmt->store_result();
					$num_rows = $stmt->num_rows;
				
					$this->numRates = $num_rows;
				 
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
								$currentRate->$key = $val;
							}
							$rates[] = $currentRate;
							$currentRate = new Rate(); 
						}
						//memcache latestposts
						setCache($user_id.'_RATING_LATEST_'.$limitLatest, $rates, $timeout);  
						return $rates;
					}
				}
				else { return $mysqli->error; }
			}//if(memcached)
		}
		else { return -1; }			
	}//function getLatestPosts($numLatest)	
}//class Sidebar
?>
