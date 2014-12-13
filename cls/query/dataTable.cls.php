<?php
class query_dataTable_cls extends query_cls
{
	function config($object)
	{
		debug_lib::msg('ff', $_GET);
		$table = $object->table;
		$iFields = $object->fields;
		$sql = $this->sql();
		$result = $sql::$table();
		$length = $_GET['length'];
		$search = isset($object->search_fields) ? $object->search_fields : false;
		if(isset($object->query)){
			$arg = func_get_args();
			$args = array_splice($arg, 2);
			array_unshift($args, $result);
			call_user_func_array($object->query, $args);
		}
		if($order = $this->get('order')){
			if($column = $this->get('columns', $order['column'])){
				$by = (isset($order['dir']) && strtolower($order['dir']) == "desc") ? "DESC" : "ASC";
				$sOrder = "order".ucfirst($iFields[$column['data']]);
				if(isset($iFields[$column['data']])){
					if(isset($object->order)){
						$continiue = call_user_func_array($object->order, array($result, $sOrder, $by));
						if($continiue){
							$result->$sOrder($by);
						}
					}else{
						$result->$sOrder($by);
					}
				}
			}
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
		if(isset($object->x)){
			$arg = func_get_args();
			$args = array_splice($arg, 2);
			array_unshift($args, $result);
			call_user_func_array($object->x, $args);
		}elseif ($search !== false && isset($_GET['search']) && isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
			$vsearch = $_GET['search']['value'];
			$vsearch = str_replace(" ", "_", $vsearch);
			$search  = join($search, ', " ", ');
			$result->condition("where", "##concat($search)", "LIKE", "%$vsearch%");
		}
		$result->limit($_GET['start'], $length);

		$query = $result->select();
		$allData = $query->allObject();
		foreach ($iFields as $ifkey => $ifvalue) {
			if(preg_match("/^([^\s]*) (.*)$/", $ifvalue, $nFields)){
				$nkey = $nFields[2];
				$okey = $nFields[1];
				$iFields[$ifkey] = $nkey;
				foreach ($allData as $vkey => $vvalue) {
					$allData[$vkey]->$nkey = $allData[$vkey]->$okey;
				}
			}
		}
		foreach ($allData as $vkey => $vvalue) {
			foreach ($vvalue as $key => $value) {
				$allData[$vkey]->$key = empty($value) ? '' : gettext($value);
			}
			if(isset($object->result)){
				call_user_func_array($object->result, array($allData[$vkey]));
			}
		}
		$array = array();
		foreach ($allData as $key => $value) {
			$iArray = array();
			foreach ($iFields as $k => $v) {
				$iArray[] = $allData[$key]->$v;
			}
			$array[] = $iArray;
		}
		$q = $result->field("#count(0)")->limit(0,10);
		debug_lib::property("draw", (int) $_GET['draw']);
		debug_lib::property("recordsTotal", $recordsTotal);
		debug_lib::property("recordsFiltered", (int) $q->select()->alist(0)[0]);
		debug_lib::property("data", $array);
		// echo($query->string());
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