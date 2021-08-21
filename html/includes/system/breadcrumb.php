<?php
class Breadcrumb
{
	//variables
	var $name; //string
	var $url; //url
	
	//properties	
	public function getName() { return $name; }

	public function setName($_name) { $this->name = $_name; }
		
	public function getUrl() { return $url; }

	public function setUrl($_url) { $this->url = $_url; }
	
}//class Breadcrumb
?>