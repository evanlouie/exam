<?php

class attempt_sqa_map {

	public $attempt_id;
	public $sqam_id;
	public $answer_id;

	function __construct() {
		mysql_connect("localhost", "root", "") or die(mysql_error());
		mysql_select_db("exam_system") or die(mysql_error());
	}

	public function get_attempt_id() {
		return $this -> attempt_id;
	}

	public function set_attempt_id($id) {
		$this -> attempt_id = $id;
		return TRUE;
	}

	public function get_sqam_id() {
		return $this -> sqam_id;
	}

	public function set_sqam_id($id) {
		$this -> sqam_id = $id;
		return TRUE;
	}

	public function get_answer_id() {
		return $this -> answer_id;
	}

	public function set_answer_id($id) {
		$this -> answer_id = $id;
		return TRUE;
	}

	public function saveToDB() {
		if (isset($this -> answer_id) && isset($this -> attempt_id) && isset($this -> sqam_id)) {
			$query = "INSERT INTO attempt_sqa_map VALUES ('$this->attempt_id', '$this->sqam_id', '$this->answer_id')";
			mysql_query($query) or die(mysql_error());
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function deleteFromDB() {
		$query = "DELETE FROM attempt_sqa_map WHERE attempt_id = '$this->attempt_id' AND sqam_id = '$this->sqam_id' AND answer_id = '$this->answer_id'";
		mysql_query($query) or die(mysql_error());
		return TRUE;
	}
	

	public function saveToDBwithNULLAnswer() {
		if (!isset($this -> answer_id) && isset($this -> attempt_id) && isset($this -> sqam_id)) {
			$query = "INSERT INTO attempt_sqa_map VALUES ('$this->attempt_id', '$this->sqam_id', NULL)";
			mysql_query($query) or die(mysql_error());
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getAttemptedAnswersAsOjectArray($attempt_id) {
		$array = array();
		$query = "SELECT * FROM attempt_sqa_map WHERE attempt_id = '$attempt_id'";
		$result = mysql_query($query) or die(mysql_error());
		while($obj = mysql_fetch_object($result)) {
			array_push($array, $obj);
		}
		return $array;
	}

}
?>