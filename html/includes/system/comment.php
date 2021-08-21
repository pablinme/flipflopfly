<?php
class Comment
{
	//variables
	var $id; //int
	var $post_id; //int
	var $user_id; //int
	var $commenterName; //string
	var $body; //string
	var $created; //date
	var $modified; //date
	var $url; //url
	var $delUrl; //url
	
	//properties
	public function getId() { return $id; }

	public function setId($_id) { $this->id = $_id; }
	
	public function getPostId() { return $post_id; }

	public function setPostId($_post_id) { $this->post_id = $_post_id; }
	
	public function getUserId() { return $user_id; }

	public function setUserId($_user_id) { $this->user_id = $_user_id; }
	
	public function getCommenterName() { return $commenterName; }

	public function setCommenterName($_commenterName) { $this->commenterName = $_commenterName; }
	
	public function getBody() { return $body; }

	public function setBody($_body) { $this->body = $_body; }
	
	public function getCreated() { return $created; }

	public function setCreated($_created) { $this->created = $_created; }
	
	public function getModified() { return $modified; }

	public function setModified($_modified) { $this->modified = $_modified; }
	
	public function getUrl() { return $url; }

	public function setUrl($_url) { $this->url = $_url; }
	
	public function getDelUrl() { return $delUrl; }

	public function setDelUrl($_delUrl) { $this->delUrl = $_delUrl; }
}//class Comment
?>
