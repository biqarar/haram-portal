<?php
class query_dataTable_cls extends query_cls
{
	function config($table, $fn = false, $search = false)
	{
		$sql = $this->sql();
		$result = $sql::$table();
		$length = $_GET['length'];
		if($order = $this->get('order')){
			if($column = $this->get('columns', $order['column'])){
				if(!is_int($column['data'])){
					$by = (isset($order['dir']) && strtolower($order['dir']) == "desc") ? "DESC" : "ASC";
					$sOrder = "order".ucfirst($column['data']);
					$result->$sOrder($by);

				}
			}
		}
		if(is_object($fn)){
			$arg = func_get_args();
			$args = array_splice($arg, 2);
			array_unshift($args, $result);
			call_user_func_array($fn, $args);
		}
		if(!isset($_SESSION['draw_'.config_lib::$surl['session']])){
			$sql_count = $this->sql();
			$result_count = $sql_count::$table();
			$count = $result_count->select()->num();
			$recordsTotal = $count;
			$_SESSION['draw_'.config_lib::$surl['session']] = $recordsTotal;
		}else{
			$recordsTotal = $_SESSION['draw_'.config_lib::$surl['session']];
		}
		$recordsFiltered = $recordsTotal;
		if($search !== false && isset($_GET['search']) && isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
			$vsearch = $_GET['search']['value'];
			$fieldSearch = preg_split("/(\s|\,)/", $search, -1, PREG_SPLIT_NO_EMPTY);
			$vsearch = str_replace(" ", "_", $vsearch);
			$fieldSearch  = join($fieldSearch, ', " ", ');
			$result->condition("where", "##concat($fieldSearch)", "LIKE", "%$vsearch%");
			// concat("");
		}
		$result->limit($_GET['start'], $length);
		$query = $result->select();
		$allData = $query->allAssoc();
		foreach ($allData as $vkey => $vvalue) {
			foreach ($vvalue as $key => $value) {
				$allData[$vkey][$key] = empty($value) ? '' :gettext($value);
			}		
		}

		$q = $result->field("#count(0)")->limit(0,10);
		debug_lib::property("draw", (int) $_GET['draw']);
		debug_lib::property("recordsTotal", $recordsTotal);
		debug_lib::property("recordsFiltered", (int) $q->select()->alist(0)[0]);
		debug_lib::property("data", $allData);
	}

	function get($name, $index = 0){
		if($gName = get::$name()){
			if(is_array($gName) && isset($gName[$index])){
				return $gName[$index];
			}
		}
		return false;
	}
}
?>