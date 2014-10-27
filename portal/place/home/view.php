<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "place";
		$this->data->list = $this->sql(".list","place");
	}
}
?>