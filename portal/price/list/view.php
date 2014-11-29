<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
		//------------------------------  global
		$this->global->page_title = "price";

		//------------------------------ load card of oldprice
		$users_id = $this->xuId("usersid");
		$x  = $this->sql(".list.card", "oldprice", $users_id , "id");
		$this->data->oldprice = $x;
		// var_dump($x);

	}
}
?>