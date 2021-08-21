<?php
/* helper functions */

function getBreadcrumbs() 
{
	global $siteCrumbs;
    $items = array(); //array of breadcrumbs
    $current = new Breadcrumb();
    $url = $siteCrumbs;
    
	$ru = URI_REQUEST;
	$qmp = strpos($ru, '?');
	
	list($path, $params) = $qmp === FALSE
	? array($ru, NULL)
	: array(substr($ru, 0, $qmp), substr($ru, $qmp + 1));
		
	$parts = explode('/', $path);
	foreach ($parts as $part)
	{
		if (strlen($part) && $part !== '..' && $part !== '.' && $part !== '/')
		{
			$url = $url.'/'.$part;
			$current->url = $url;
			$current->name = $part;
			$items[] = $current;
		}
		
		$current = new Breadcrumb(); 
	}

	return $items;
}

// get list of countries
function getCountries()
{
	global $mysqli;
	global $meminstance;
	
	$countries = array();

	//frist we check if memcache is set
	if ($meminstance == true)
	{
		// We build the key associated to countries list
		$key = '_COUNTRIES_';
 
		// Now we get the data from our cache server
		$countries = getCache($key);
		if($countries) { return $countries; }
	}

	//if we do not have a value on cache, we fetch from db and then save it to cache
	if (!$countries)
	{
		
		if ($stmt = $mysqli->prepare("SELECT countryCode,countryName FROM countries ORDER BY countryName")) 
		{ 
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			$num_rows = $stmt->num_rows;
				
			//store the list on cache 
			if($num_rows > 0)
			{
				$meta = $stmt->result_metadata();
				$parameters = array();
				while ($field = $meta->fetch_field()) { $columns[] = &$row[$field->name]; }
				mysqli_free_result($meta);
				call_user_func_array(array($stmt, 'bind_result'), $columns);
				
				$country = array("countryCode" => "", "countryName" => "");
				while ($stmt->fetch()) 
				{ 
					foreach($row as $key => $val) { $country[$key] = $val; } 
					$countries[] = $country;
					//
				}
				//memcache latestposts
				setCache('_COUNTRIES_', $countries, 86400);  
				return $countries;

			}
		}
		else return false;
	}
}//function getCountries()


 # Gets key / value pair into memcache
function getCache($key) 
{
    global $memcache;
    return ($memcache) ? $memcache->get($key) : false;
}

# Puts key / value pair into memcache
function setCache($key,$object,$timeout = 60) 
{
    global $memcache;
    return ($memcache) ? $memcache->set($key,$object,MEMCACHE_COMPRESSED,$timeout) : false;
}

//clean for html link
function clean($string) 
{
   $string = str_replace(" ", "-", $string); // Replaces all spaces with hyphens.
   $string = replace_accents($string); // Replaces special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function replace_accents($string)
{
  return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string);
}

// check data
function checkData($optn, $value)
{
	global $mysqli;
	
	if($optn == 'user') 
	{
		if ($stmt = $mysqli->prepare("SELECT name FROM members WHERE username = ?")) 
		{ 
			$stmt->bind_param('s', $value);
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			$num_rows = $stmt->num_rows;
				 
			//if the username is taken
			if($num_rows > 0) return false;
			else return true;
		}
		else return false;
	}
	
	if($optn == 'email')
	{
		if ($stmt = $mysqli->prepare("SELECT name FROM members WHERE email = ?")) 
		{ 
			$stmt->bind_param('s', $value);
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			$num_rows = $stmt->num_rows;
				 
			//if the username is taken
			if($num_rows > 0) return false;
			else return true;
		}
		else return false;
	}
	
}//function checkData($optn, $value)

function render($template, $vars = array())
{	
	// This function takes the name, parameters and renders it.
	
	// This will create variables from the array:
	extract($vars);
	
	// It can also take an array of objects
	if(is_array($template))
	{	
		// Partial views
		foreach($template as $k)
		{	
			// This will create a local variable
			$cl = strtolower(get_class($k));
			$$cl = $k;
			
			include "views/_$cl.php";
		}
		
	}
	else { include "views/$template.php"; }
}

// Helper function for title formatting:
function formatTitle($title = '')
{
	if($title) { $title.= ' | '; }
	
	$title .= $GLOBALS['defaultTitle'];
	
	return $title;
}
?>
