<?php
class Rate
{
	//variables
	var $id; //int
	var $raterName; //string
	var $totalVotes; //int
	var $totalValue; //int
	var $raterId; //int
	var $ratedId; //int
	var $date; //date

	
	//properties
	public function getId() { return $id; }

	public function setId($_id) { $this->id = $_id; }
	
	public function getRaterName() { return $raterName; }

	public function setraterName($_raterName) { $this->raterName = $_raterName; }

	public function getTotalVotes() { return $totalVotes; }

	public function setTotalVotes($_totalVotes) { $this->totalVotes = $_totalVotes; }
	
	public function getRaterId() { return $raterId; }

	public function setRaterId($_raterId) { $this->raterId = $_raterId; }
	
	public function getRatedId() { return $ratedId; }

	public function setRatedId($_ratedId) { $this->ratedId = $_ratedId; }
	
	public function getDate() { return $date; }

	public function setDate($_date) { $this->date = $_date; }
}//class Post
?>
