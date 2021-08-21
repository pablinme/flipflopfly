<?php
/* The login details are taken from config.php. */

	$memcache = new Memcache();
	$meminstance = $memcache->connect($memcached_host, $memcached_port);
	
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $mysqli->query("SET NAMES 'utf8'");
	
	if ($mysqli->error) 
	{
    	try 
		{    
    	    throw new Exception("MySQL error $mysqli->error <br>");    
		} 
    
		catch(Exception $e )
		{
			echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			echo nl2br($e->getTraceAsString());
		}
	}
?>
