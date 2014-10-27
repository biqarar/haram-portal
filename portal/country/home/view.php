<?php
 /**
* 
*/
class view extends main_view {
	public function config() {
		$list = $this->sql(".list", "country");
		$this->data->list = $list->compile();
	}
} 
?>