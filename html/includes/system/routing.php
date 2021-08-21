<?php
class Routing 
{
	//variables
	var $_backbone;
    var $_params;
    
    //properties
    function getBackbone() { return $this->_backbone; }
	function getParams() { return $this->_params; }
	
	//constructor
	function Routing()
	{
		/*=========== constants ==========*/
		define('DIR_WEB', dirname(__FILE__));
		define('DIR_MODUP', DIR_WEB);
		define('DIR_SYS', DIR_MODUP.'/');
		define('DIR_CTRL', DIR_MODUP.'/routes');

		//disecting the URI
		$ru = $_SERVER['REQUEST_URI'];
		$qmp = strpos($ru, '?');
		
		list($path, $params) = $qmp === FALSE
		? array($ru, NULL)
		: array(substr($ru, 0, $qmp), substr($ru, $qmp + 1));
		
		$parts = explode('/', $path);
		$i = 0;
		foreach ($parts as $part)
		{
			if (strlen($part) && $part !== '..' && $part !== '.')
			{
				define('URI_PART_'.$i++, $part);
			}
		}
		
		$tmp = explode('/', $ru);
		
		if(strstr($tmp[1], '?'))
		{
			$val = explode('?', $tmp[1]);
			$backbone = $val[0];
		}
		else $backbone = $tmp[1];
	
		if($backbone == null) $backbone = $path; //go to home
		
		define('URI_PARAM', isset($params) ? '' : $params);
		define('URI_PARTS', $i);
		define('URI_PATH', $path);
		define('URI_BACKBONE', $backbone);
		define('URI_REQUEST', $_SERVER['REQUEST_URI']);
		
		//routing and other init
		include "includes/system/router.php";
		include "includes/system/config.routes.php";
	
		$this->_backbone = $backbone;
		$this->_params = $params;
	}
}
?>
