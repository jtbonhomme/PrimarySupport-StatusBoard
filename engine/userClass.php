<?php

class UserClass {

	protected static $table_name = "users";
	public $uid;
	public $firstname;
	public $lastname;
	public $email;
	

	
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
	
	public static function find_by_uid($uid = NULL) {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE uid = '" . $uid . "' ";
		$sql .= "LIMIT 1";
				
		$result_array = self::find_by_sql($sql);
		
		return (!empty($result_array) ? array_shift($result_array) : false);
		
	}
	
	public function active_technicians() {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE type IN ('Administrator', 'Technician') ";
		$sql .= "AND active = 1 ";
		$sql .= "ORDER BY firstName ASC";
				
		$result_array = self::find_by_sql($sql);
		
		return ($result_array);
	}

		
}
?>