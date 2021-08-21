<?php
class User
{
	//variables
	var $id; //int
	var $username; //int
	var $name; //string
	var $lastname; //string
	var $gender; //string
	var $country; //string
	var $date; //date
	var $url; //url
	
	//properties
	public function getId() { return $id; }

	public function setId($_id) { $this->id = $_id; }
	
	public function getUsername() { return $username; }

	public function setUsername($_username) { $this->username = $_username; }
	
	public function getName() { return $name; }

	public function setName($_name) { $this->name = $_name; }
	
	public function getLastname() { return $lastname; }

	public function setLastname($_lastname) { $this->lastname = $_lastname; }
	
	public function getGender() { return $gender; }

	public function setGender($_gender) { $this->gender = $_gender; }
	
	public function getCountry() { return $country; }

	public function setCountry($_body) { $this->country = $_country; }
	
	public function getDate() { return $date; }

	public function setDate($_date) { $this->date = $_date; }
	
	public function getUrl() { return $url; }

	public function setUrl($_url) { $this->url = $_url; }
	
}//class User
?>
