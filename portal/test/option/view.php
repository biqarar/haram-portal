<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->data->list = $this->sql(".list", "person" , function ($query){
			$query->whereId(14000);
		})->compile();
	}
}
?>