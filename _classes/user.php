<?php

class user {

	public $user_id;
	private $first_name;
	private $last_name;
	private $email;
	private $password;

	function __construct() {
		mysql_connect("localhost", "root", "") or die(mysql_error());
		mysql_select_db("exam_system") or die(mysql_error());
	}

	public function getFromDB($user_id) {
		$query = "SELECT * FROM user WHERE user_id = '$user_id'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while ($obj = mysql_fetch_object($result)) {
				$this -> email = $obj -> email;
				$this -> first_name = $obj -> first_name;
				$this -> last_name = $obj -> last_name;
				$this -> password = $obj -> password;
				$this -> user_id = $obj -> user_id;
			}
		} else {
			return FALSE;
		}

	}

	public function get_user_id() {
		return $this -> user_id;
	}

	public function set_user_id($id) {
		$this -> user_id = $id;
		return TRUE;
	}

	public function get_first_name() {
		return $this -> first_name;
	}

	public function set_first_name($fname) {
		$this -> first_name = $fname;
		return TRUE;
	}

	public function get_last_name() {
		return $this -> last_name;
	}

	public function set_last_name($lname) {
		$this -> last_name = $lname;
		return TRUE;
	}

	public function get_email() {
		return $this -> email;
	}

	public function set_email($email) {
		$this -> email = $email;
		return TRUE;
	}

	public function get_password() {
		return $this -> password;
	}

	public function set_password($password) {
		$this -> password = $password;
		return TRUE;
	}

	public function saveToDB() {
		if (isset($this->user_id)) {
			die("user_id set; object already exists in DB");
		} else {
			$query = "INSERT INTO user VALUES (NULL, '$this->first_name', '$this->last_name', '$this->email', '$this->password')";
			mysql_query($query) or die(mysql_error());
			return TRUE;
		}
	}

	public function deleteFromDB() {
		if (!isset($this->user_id)) {
			die("user_id not set; no object referenced in DB");
		} else {
			$query = "DELETE FROM user WHERE user_id = '$this->user_id'";
			mysql_query($query) or die(mysql_error());
			return TRUE;
		}
	}

	public function updateInDB() {
		if (!isset($this->user_id)) {
			die("user_id not set; no object referenced in DB");
		} else {
			$query = "UPDATE user SET first_name = '$this->first_name', last_name = '$this->last_name', email = '$this->email', password = '$this->password' WHERE user_id = '$this->user_id'";
			mysql_query($query) or die(mysql_error());
			return TRUE;
		}
	}

	public function availableEmail($email) {
		$query = "SELECT * FROM user WHERE email = '$email'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_user_id_fromDB($email) {
		$query = "SELECT * FROM user WHERE email = '$email'";
		$result = mysql_query($query) or die(mysql_error());
		while ($obj = mysql_fetch_object($result)) {
			return $obj -> user_id;
		}
	}

	public function getAllAttemptObjects() {
		$attempts = array();
		$query = "	SELECT DISTINCT
						e.title,
						a.score,
						a.timestamp,
						a.attempt_id,
						e.exam_id,
						a.out_of
					FROM
						user as u,
						attempt as a,
						attempt_exam_map as aem,
						exam as e
					WHERE
						'$this->user_id' = u.user_id AND
						u.user_id = a.user_id AND
						a.attempt_id = aem.attempt_id AND
						aem.exam_id = e.exam_id
					ORDER BY
						a.attempt_id";

		$result = mysql_query($query) or die(mysql_error());
		while ($obj = mysql_fetch_object($result)) {
			array_push($attempts, $obj);
		}
		return $attempts;
	}

	public function isPasswordRight($password) {
		if ($password == $this -> password) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function userExists($email) {
		$query = "SELECT * FROM user WHERE email = '$email'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function getAllUserID() {
		$query = "SELECT user_id FROM user";
		$result = mysql_query($query) or die(mysql_error());
		$array = array();
		while ($obj = mysql_fetch_object($result)) {
			array_push($array, $obj);
		}
		return $array;
	}
	
	public function deleteUserAndAllInformation() {
		$query = "SELECT * FROM attempt WHERE user_id = '$this->user_id'";
		$result = mysql_query($query) or die(mysql_error());
		while($obj = mysql_fetch_object($result)) {
			$q = "DELETE FROM attempt_sqa_map WHERE attempt_id = '$obj->attempt_id' ";
			mysql_query($q) or die(mysql_error());
			$q = "DELETE FROM attempt_exam_map WHERE attempt_id = '$obj->attempt_id' ";
			mysql_query($q) or die(mysql_error());
			$q = "DELETE FROM attempt WHERE attempt_id = '$obj->attempt_id' ";
			mysql_query($q) or die(mysql_error());
		}
		$q = "DELETE FROM admin WHERE user_id = '$this->user_id'";
		mysql_query($q) or die(mysql_error());
		$q = "DELETE FROM user WHERE user_id = '$this->user_id'";
		mysql_query($q) or die(mysql_error());
	}

}
?>