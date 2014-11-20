<?php
class query_dataTable_cls extends query_cls
{
	function config($table, $fn = false, $search = false)
	{
		$sql = $this->sql();
		$result = $sql::$table();
		$length = $_GET['length'];

		if(!isset($_SESSION['draw_'.config_lib::$surl['session']])){
			$sql_count = $this->sql();
			$result_count = $sql_count::$table();
			$count = $result_count->select()->num();
			$recordsTotal = $count;
			$_SESSION['draw_'.config_lib::$surl['session']] = $recordsTotal;
		}else{
			$recordsTotal = $_SESSION['draw_'.config_lib::$surl['session']];
		}
		if(is_object($fn)){
			$arg = func_get_args();
			$args = array_splice($arg, 2);
			array_unshift($args, $result);
			call_user_func_array($fn, $args);
		}
		$recordsFiltered = $recordsTotal;
		if($search !== false && isset($_GET['search']) && isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
			$vsearch = $_GET['search']['value'];
			foreach (preg_split("[\s,]", $search) as $key => $value) {
				if(empty($value)) continue;
				$cond = "orlike".ucfirst($value);
				$result->$cond("%$vsearch%");
			}
		}
		$result->limit($_GET['start'], $length);
		$query = $result->select();
		$allData = $query->allAlist();
		foreach ($allData as $vkey => $vvalue) {
			foreach ($vvalue as $key => $value) {
				$allData[$vkey][$key] = empty($value) ? '' :gettext($value);
			}		
		}
		$q = $result->field("#count(id)")->limit(0,10);
		debug_lib::property("draw", (int) $_GET['draw']);
		debug_lib::property("recordsTotal", $recordsTotal);
		debug_lib::property("recordsFiltered", (int) $q->select()->alist(0)[0]);
		debug_lib::property("data", $allData);
		// echo (int) $q->select()->alist(0)[0];
		// echo "\n";
	}
}
?>