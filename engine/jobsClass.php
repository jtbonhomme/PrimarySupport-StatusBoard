<?php

class jobsClass {

	protected static $table_name = "jobs";
	public $uid;
	public $active;
	public $school_uid;
	public $entry;
	public $description;
	public $type;
	public $owner_uid;
	public $category;
	public $priority;
	public $user_uid;
	public $last_update;
	public $job_closed;
	public $totalJobs;
	public $spawn;
	
	public static function find_by_sql($sql="") {
		global $database;
		
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
			global $database;
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	private static function instantiate($record) {
		
	$object = new self;
		foreach ($record as $attribute=>$value) {
			if ($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
		// get_object_vars returns as associative array with all attributes
		// (incl. private ones!) as the keys and their current values as the value
		$object_vars = $this->attributes($this) ;
		
		// we don't care about the value, we just want to know if the key exists
		// will return true or false
		return array_key_exists($attribute, $object_vars);
	}
	
	private function attributes($attribute) {
		return get_object_vars($this);
	}
	
	//////////////////////
	  //////////////////
	//////  ACTIVE  //////
	  //////////////////
	//////////////////////
	
	public function find_by_uid($uid = NULL) {
		$sql = ("SELECT * FROM " . self::$table_name . " WHERE uid = '" . $uid . "'");
		
		$job = self::find_by_sql($sql);
		
		return (!empty($job) ? array_shift($job) : false);
	}
	
	public function active_jobs() {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND active = '1'";
		
		return self::find_by_sql($sql);
	}
	
	public function active_jobs_by_owner_uid($userUID) {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND active = '1' ";
		$sql .= "AND owner_uid = '" . $userUID . "' ";
				
		$result_array = self::find_by_sql($sql);
		
		return $result_array;
	}
	
	public function active_jobs_by_priority($priority = 1) {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND active = '1' ";
		$sql .= "AND priority = '" . $priority . "' ";
				
		$result_array = self::find_by_sql($sql);
		
		return $result_array;
	}
	
	public function new_jobs_by_day($date = NULL) {
		if ($date == NULL) {
			$date = strtotime(date('Y-m-d'));
		} else {
			$date = strtotime($date);
		}
				
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		//$sql .= "AND active = '1' ";
		$sql .= "AND DATE(entry) = '" . date('Y-m-d', $date) . "' ";
		$sql .= "ORDER BY entry ASC";
		
		return self::find_by_sql($sql);
	}
	
	public function new_updates_by_day($date = NULL) {
		if ($date == NULL) {
			$date = strtotime(date('Y-m-d'));
		} else {
			$date = strtotime($date);
		}
				
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Response' ";
		$sql .= "AND DATE(entry) = '" . date('Y-m-d', $date) . "' ";
		$sql .= "ORDER BY entry ASC";
				
		return self::find_by_sql($sql);
	}
	
	public function todays_updates_by_userUID($userUID = NULL) {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Response' ";
		$sql .= "AND DATE(entry) = DATE(NOW()) ";
		$sql .= "AND user_uid = '" . $userUID . "' ";
		$sql .= "ORDER BY entry ASC";
				
		return self::find_by_sql($sql);
	}
	
	public function jobs_updated_by_day($date = NULL) {
		if ($date == NULL) {
			$date = strtotime(date('Y-m-d'));
		} else {
			$date = strtotime($date);
		}
				
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND DATE(last_update) = '" . date('Y-m-d', $date) . "' ";
		$sql .= "ORDER BY entry DESC";
		
		return self::find_by_sql($sql);
	}
	
	public function description($limit = NULL) {
		if ($limit !== NULL) {
			$description = substr($this->description, 0, $limit);
		}
		
		return $description;
	}
	
	public function not_stagnant_jobs_by_userUID($userUID = NULL) {
		$yesterday = strtotime(date("Y-m-d", time()-86400));
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND active = 1 ";
		$sql .= "AND last_update >= '" . date('Y-m-d', $yesterday) . "' ";
		$sql .= "AND owner_uid = '" . $userUID . "' ";
		$sql .= "ORDER BY entry ASC";
		
		return self::find_by_sql($sql);
	}
	
	public function stagnant_jobs_by_userUID($userUID = NULL) {
		$yesterday = strtotime(date("Y-m-d", time()-86400));
		$daysAgo = strtotime(date("Y-m-d", time()-432000));
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND active = 1 ";
		$sql .= "AND last_update < '" . date('Y-m-d', $yesterday) . "' ";
		$sql .= "AND last_update > '" . date('Y-m-d', $daysAgo) . "' ";
		$sql .= "AND owner_uid = '" . $userUID . "' ";
		$sql .= "ORDER BY entry ASC";
		
		return self::find_by_sql($sql);
	}
	
	public function very_stagnant_jobs_by_userUID($userUID = NULL) {
		$yesterday = strtotime(date("Y-m-d", time()-86400));
		$daysAgo = strtotime(date("Y-m-d", time()-432000));
		
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type = 'Job' ";
		$sql .= "AND active = 1 ";
		$sql .= "AND last_update <= '" . date('Y-m-d', $daysAgo) . "' ";
		$sql .= "AND owner_uid = '" . $userUID . "' ";
		$sql .= "ORDER BY entry ASC";
		
		return self::find_by_sql($sql);
	}
}
?>