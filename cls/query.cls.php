<?php
class query_cls{
	public final function sql($name = false){
		if(preg_match("/^(\.|@|#)/Ui", $name)){
			$args = func_get_args();
			return call_user_func_array(array(main_lib::$controller, 'sql'), $args);
		}
		$sql = new sqlMaker_lib();
		$querys = main_lib::$controller->querys;
		if($name){
			$querys->$name = $sql;
		}else{
			$name = preg_replace("/_cls$/", "", get_class($this));
			$sName = $name;
			$continue = true;
			$count = 0;
			do{
				if(!isset($querys->$sName)){
					$continue = false;
				}else{
					++$count;
					$sName = "{$name}_$count";
				}
			}while ($continue);

			$querys->$sName = $sql;
		}
		return $sql;
	}
}
?>