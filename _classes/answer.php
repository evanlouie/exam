<?php

class answer {

	public $answer_id;
	public $answer;

	function __construct() {
		mysql_connect("localhost", "root", "") or die(mysql_error());
		mysql_select_db("exam_system") or die(mysql_error());
	}

	public function getFromDB($answer_id) {
		$query = "SELECT * FROM answer WHERE answer_id = '$answer_id'";
		$result = mysql_query($query);
		while ($answer = mysql_fetch_object($result)) {
			$this -> answer_id = $answer -> answer_id;
			$this -> answer = $answer -> answer;
		}
	}

	public function get_answer_id() {
		return $this -> answer_id;
	}

	public function set_answer_id($id) {
		$this -> answer_id = $id;
		return TRUE;
	}

	public function get_answer() {
		return $this -> answer;
	}

	public function set_answer($answer) {
		$this -> answer = $answer;
		return TRUE;
	}

	public function saveToDatabase() {
		if (!isset($this->answer)) {
			die("No answer text is set");
		} else if (isset($this->answer_id)) {
			die("answer_id is set; therefore object must already exist in DB");
		} else {
			$query = "INSERT INTO answer VALUES (NULL, '$this->answer')";
			mysql_query($query) or die(mysql_error());
			return TRUE;
		}
	}

	public function deleteFromDatabase() {
		$query = "DELETE FROM answer WHERE answer_id = '$this->answer_id'";
		mysql_query($query) or die(mysql_error());
		return TRUE;
	}

	public function updateAnswerInDB() {
		$query = "UPDATE answer SET answer = '$this->answer' WHERE answer_id = '$this->answer_id'";
		mysql_query($query) or die(msyql_error());
		return TRUE;
	}
	
	public function getListOfAllAnswersAsObjectArray() {
		$query = "SELECT * FROM answer";
		$result = mysql_query($query) or die(mysql_error());
		$array = array();
		while($obj = mysql_fetch_object($result)) {
			array_push($array, $obj);
		}
		return $array;
	}

}
?>