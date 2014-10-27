<?php 
/**
* @author reza mohiti
*/
class condition {

	public $condition = array();

	public function check($args) {
		if(is_array($args)){
			if(is_array($args[0])){
				if(preg_grep("/\,|\s/", $args[0])){
					return preg_split("/\,|\s/", $args[0]);
				}else{
					return $args[0];
				}
			}else{
				if(preg_match("/\,|\s/", $args[0])){
					return preg_split("/\,|\s/", $args[0]);
				}else{
					return $args;
				}
			}
		}elseif (preg_match("/\,|\s/", $args)) {
			return preg_split("/\,|\s/", $args);
		}else{
			return array($args);
		}
	}	

	public function add($name, $value) {
		$this->condition[$name] = $this->check($value);
	}

	public function push($name = false, $value = false) {
		if(isset($this->condition[$name])){
			foreach ($this->check($value) as $k => $v) {
				$if = preg_grep("/$v/", $this->condition[$name]);
				if(empty($if)){
					$this->condition[$name][] = $v;
				}
			}
		}else{
			call_user_func_array(array($this,"add"), array($name, $value));
		}
	}

	public function remove($name = false, $value = false) {
		if(!$value){
			if(isset($this->condition[$name])){
				unset($this->condition[$name]);
			}
		}elseif(isset($this->condition[$name])){
			$delete = array_flip($this->condition[$name]);
			$index_delete = array();
			foreach ($delete as $k => $v) {
				foreach ($this->check($value) as $kk => $vv) {
					if($vv == $k){
						unset($this->condition[$name][$v]);
					}
				}
			}
		}
	}

	 public function __call($func, $args) {		
		preg_match("/^([a-z]+)([A-Z].*)?$/", $func, $caller);
		call_user_func_array(array($this,$caller[1]), array(lcfirst($caller[2]),$args));
		return $this;
	}
	
	public function save() {
		$return = "";
		foreach ($this->condition as $key => $value) {
			$return .= $key . '=';
			if(is_array($value)){
				foreach ($value as $k => $v) {
					$return .= $v . ',';
				}
			}else{
				$return .= $value . ',' ;
			}
			$return = preg_replace("/\,$/", '', $return);
			$return .= ';';
		}
		$return = preg_replace("/\;$/", '', $return);
		return $return;
	}

	public function get($condition = false) {
		$return = array();
		$condition = preg_split("/\;/", $condition);
		foreach ($condition as $key => $value) {
			$cond = preg_split("/\=/", $value);
			$name= $cond[0];
			$value = preg_split("/\,/", $cond[1]);
			$return[$name] = $value;
		}
		return $return;
	}

	public function getFlip($condition = false){
		$ret = $this->get($condition);
		$return = array();
		foreach ($ret as $key => $value) {
			$return[$key] = array_flip($value);
		}
		return $return;
	}
}

 ?>