<?php
require_once "includes/main.php";

/* It routes requets to the appropriate controllers */
try 
{	
	$routing = new Routing();
	$session = new session();
	$session->start_session('_s', false); //for TLS set true
	
	if($router = Router::start()) { include $router; }	
}
catch(Exception $e) { render('message', array('title'=>'bad request', 'body'=>$e->getMessage())); }
?>
