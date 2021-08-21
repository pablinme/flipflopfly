<?php
class Post
{
	//variables
	var $id; //int
	var $content; //string
	var $date; //date
	var $topic; //int
	var $userId; //int
	var $url; //url
	
	var $posterName; //string
	
	//properties
	public function getId() { return $id; }

	public function setId($_id) { $this->id = $_id; }
	
	public function getContent() { return $content; }

	public function setContent($_content) { $this->content = $_content; }
	
	public function getDate() { return $date; }

	public function setDate($_date) { $this->date = $_date; }
	
	public function getTopic() { return $topic; }

	public function setTopic($_topic) { $this->topic = $_topic; }
	
	public function getUserId() { return $userId; }

	public function setUserId($_userId) { $this->userId = $_userId; }
	
	public function getUrl() { return $url; }

	public function setUrl($_url) { $this->url = $_url; }
	
	public function getPosterName() { return $posterName; }

	public function setPosterName($_posterName) { $this->posterName = $_posterName; }

}//class Post
?>
