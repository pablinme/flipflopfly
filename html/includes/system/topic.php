<?php
class Topic
{
	//variables
	var $id; //int
	var $subject; //string
	var $date; //date
	var $category; //int
	var $by; //int
	
	var $posterName; //string
	var $url; // string
	
	//properties
	public function getId() { return $id; }

	public function setId($_id) { $this->id = $_id; }
	
	public function getSubject() { return $subject; }

	public function setSubject($_subject) { $this->subject = $_subject; }
	
	public function getDate() { return $date; }

	public function setDate($_date) { $this->date = $_date; }
	
	public function getCategory() { return $category; }

	public function setCategory($_category) { $this->category = $_category; }
	
	public function getBy() { return $by; }

	public function setBy($_by) { $this->by = $_by; }
	
	public function getPosterName() { return $posterName; }

	public function setPosterName($_posterName) { $this->posterName = $_posterName; }
	
	public function getUrl() { return $url; }

	public function setUrl($_url) { $this->url = $_url; }
	
}//class Topic
?>
