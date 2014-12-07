<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class controller extends main_controller{
	public $access = true;
	function config(){	
		$this->listen(array(
			'max' => 3,
			'url' => array("ahmad", "status" => "shit")
			), array("ahmad", "option")
		);

	}

}
?>