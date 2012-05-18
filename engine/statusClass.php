<?php

class statusClass {

	protected static $table_name = "ticket_status";
	public $uid;
	public $status;
	
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
		
		return self::find_by_sql($sql);
	}
	
	public function find_all_active() {
		$sql  = "SELECT * FROM " . self::$table_name . " ";
		$sql .= "WHERE uid <> '5' ";
		$sql .= "AND uid <> '1'";
		$sql .= "AND uid <> '7'";
		
		return self::find_by_sql($sql);
	}
}

?>