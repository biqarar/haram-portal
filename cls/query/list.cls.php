<?php
class query_list_cls extends query_cls
{
	function config($table, $fn = false)
	{
		$sql = $this->sql();
		$result = $sql::$table();
		if(is_object($fn)){
			$arg = func_get_args();
			$args = array_splice($arg, 2);
			array_unshift($args, $result);
			call_user_func_array($fn, $args);
		}

		$query = $result->select();

		$fl = $query->oFieldNames();
		$header = array();
		$tables = array();
		foreach ($fl as $key => $value) {
			if(!isset($tables[$value->orgtable])){
				$cName = "\\sql\\{$value->orgtable}";
				$tables[$value->orgtable] = new $cName;
			}
			$tbl = $tables[$value->orgtable];
			$index = $value->name;
			$label = isset($tbl->{$value->orgname}['label']) ? $tbl->{$value->orgname}['label'] : $value->name;
			$header[$index] = $label;
		}
		return new show_lib($header, $query->allAssoc());
	}
}
?>