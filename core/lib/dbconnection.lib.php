<?php
class dbconnection_lib{
	
	private $converted_to_object	= false;
	private $record_is_called		= false;
	private $assoc_is_called		= false;
	private $save					= false;
	private $allrecord				= array();
	private $allassoc				= array();
	private $allobject				= array();
	private $i						= 0;
	
	public $result					= false;
	public  static $resum_on_error			= false;

	public $status					= true;
	public $string					= false;
	public $error					= false;
	public $fieldNames				= array();
	public $oFieldNames				= array();
	public static $connection		= false;
	public static $dbConnection		= array();
	public static $db_name_selected	= false;


	public function __construct(){
		$cls = debug_backtrace();
		if(isset($cls[1]['class']) && $cls[1]['class'] == 'sql_lib'){
			$this->cls = $cls[1]['object'];
		}
		$db_name = self::$db_name_selected != false ? self::$db_name_selected : db_name;
		if(!isset(self::$dbConnection[$db_name])){
			self::$connection = new mysqli(db_host, db_user, db_password, $db_name);
			if(self::$connection->connect_errno == 0 ){
				self::$connection->set_charset(db_charset);
				self::$dbConnection[$db_name] = self::$connection;
			}else{
				$this->error(self::$connection->connect_error, self::$connection->connect_errno);
			}
		}
	}
	public function query($string){
		$patterns = array(
			'/ة/',
			'/إ/',
			'/أ/',
			'/ي/',
			'/ئ/',
			'/ؤ/',
			'/ك/',

			'/۰/',
			'/۱/',
			'/۲/',
			'/۳/',
			'/۴/',
			'/۵/',
			'/۶/',
			'/۷/',
			'/۸/',
			'/۹/'
			);
		$replacements = array(
			'ه',
			'ا',
			'ا',
			'ی',
			'ی',
			'و',
			'ک',

			'0',
			'1',
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9'
			);
		// var_dump($string);
		$string = preg_replace($patterns, $replacements, $string);
		if(debug_lib::$status || self::$resum_on_error){
			$this->string = $string;
			$this->result = self::$connection->query($string);
			if (self::$connection->error) {
				$this->status = false;
				$this->error(self::$connection->error, self::$connection->errno);

			}
		}
		return $this;
	}

	public function error($error = null, $errno = null) {
		$reg = new dberror_lib();
		$f = "$errno";
		$aError = $reg->$f($error);
		$this->error = $aError;
		if(isset($this->cls) && $this->error && isset($this->cls->table) &&isset($this->cls->tables[$this->cls->table])){
			$table = $this->cls->tables[$this->cls->table];
			$fieldName = $this->error['fieldname'];
			$errorName = isset($this->error['errorName']) ? $this->error['errorName'] : $this->error['errno'];
			if($table->{$fieldName}->closure->validate){
				$error = isset($table->{$fieldName}->closure->validate->sql->{$errorName}) ? $table->{$fieldName}->closure->validate->sql->{$errorName} : false;
				debug_lib::fatal($error, $errorName, 'sql');
			}
		}else{
			debug_lib::fatal($error, $errno, 'sql');
		}
		return $aError;
	}

	public function result() {
		if($this->status){
			return $this->result;
		}else{
			return false;
		}
	}

	public function save() {
		$this->save = true;
		return $this;
	}

	public function endSave() {
		$this->save = false;
		return $this->allrecord;
	}

	private function onSave($i, $result) { 
		if ($this->save) {
			$this->allrecord[$i] = (array) $result; return $this;
		} else { 
			return $result; 
		}
	}

	private function _return($i, $field = null) {
		if (!is_int($i)) {
			$field = $i;
			$i = $this->i;
		}
		$this->check_i($i);
		$ret = $this->record_is_called();
		if (!empty($this->allrecord[$this->i])) {
			if (gettype($field) == 'object') {
				$args   = func_get_args();
				$args   = array_splice($args, 2);
				array_unshift($args, $this->allrecord[$this->i]);
				$return = call_user_func_array($field, $args);
			} elseif ($field) {
				$return = $this->allrecord[$this->i][$field];
			} else {
				$return = $this->allrecord[$this->i];
			}
			$this->i++;
			return $this->onSave(($this->i - 1), $return);
		} else {
			return false;
		}
	}


	public function fieldNames(){
		$this->record_is_called();
		return $this->fieldNames;
	}

	public function oFieldNames(){
		$this->record_is_called();
		return $this->oFieldNames;
	}

	private function record_is_called() {
		if (!$this->record_is_called) {
			if ($this->result !== null) {
				$this->record_is_called = true;
				if(method_exists($this->result, "fetch_fields")){
					$fields = $this->result->fetch_fields();
					$aFields = array();
					foreach ($fields as $key => $value) {
						if(array_search($value->name, $aFields) === false){
							$this->oFieldNames[] = $value;
							$aFields[$key] = $value->name;
						}
					}
					$this->fieldNames = $aFields;
					while ($x = $this->result->fetch_array()) {
						$record = array();
						foreach ($aFields as $key => $value) {
							$record[$value] = html_entity_decode($x[$key], ENT_QUOTES | ENT_HTML5, "UTF-8");
						}
						$this->allrecord[] = $record;
					}
				}
			}
		}
	}

	private function convert_to_array($object = null) {
		$all = array();
		foreach ($object as $key => $value) {
			$all[$key] = (array) $value;
		}
		return $all;
	}

	private function convert_to_object($array = null) {
		if (!$this->converted_to_object) {
			if (!$array) {
				$this->record_is_called();
				$array = $this->allrecord;
			}
			$all = array();
			foreach ($array as $key => $value) {
				$all[$key] = (object) $value;
			}
			$this->converted_to_object = true;
			$this->allobject = $all;
		}
		return $this->allobject;
	}

	private function check_i($i) {
		if ($i) {
			$this->i = $i;
		}
		if ($i < 0) {
			$this->i = 0;
		}
	}

	public function assoc($i = null, $field = null) {
		return call_user_func_array(array($this, "_return"), array($i, $field));
	}

	public function allAssoc($field = null) {
		$this->i = 0;
		$all = array();
		while ($x = $this->assoc($field)) {
			$all[] = $x;
		}
		return ($this->save) ? $this : $all;
	}

	public function alist($i = null, $field = null) {
		$array = call_user_func_array(array($this, "_return"), array($i, $field));
		if(is_array($array)){
			return array_values($array);
		}else{
			return $array;
		}
	}

	public function allAlist($field = null) {
		$this->i = 0;
		$all = array();
		while ($x = $this->alist($field)) {
			$all[] = $x;
		}
		return ($this->save) ? $this : $all;
	}

	public function object($i = null, $field = null) {
		$return = call_user_func_array(array($this, "_return"), array($i, $field));
		return ($return) ? (is_array($return)) ? (object) $return : $return  : false;
	}

	public function allObject($field = null) {
		$all = array();
		$this->i = 0;
		while ($x = $this->object($field)) {
			$all[] = $x;
		}
		return ($this->save) ? $this : $all;
	}

	public function string() {
		return $this->string;
	}

	public function num() {
		if ($this->status){	
			if(!$this->result){
				return 0;
			}
			return $this->result->num_rows;
		}else{
			return false;
		}
	}

	public function LAST_INSERT_ID() {
		if ($this->status){
			return self::$connection->insert_id;
		}else{
			return false;
		}
	}
}
?>