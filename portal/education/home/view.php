<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title = "education";
		$this->data->list = $this->sql(".list","education")->compile();
	}
}
?>