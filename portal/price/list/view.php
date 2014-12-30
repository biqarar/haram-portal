<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
		//------------------------------  global
		$this->global->page_title = "price";

		$this->data->dataTable = $this->dtable(
			"price/status=api/", 
			array('id', "users_id", "date", "pay_type", "value", "title", "transactions" ,"description"));
	}
}
?>