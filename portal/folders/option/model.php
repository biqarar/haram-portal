<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableFolders()
				->setName(post::name())
				->setAdress(post::adress());
	}

	public function post_add_folders(){
		$sql = $this->makeQuery()->insert();

		$this->commit(function() {
			debug_lib::true("[[insert folders successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert folders failed]]");
		});
	}

	public function post_edit_folders(){
		$sql = $this->makeQuery()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update folders ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update folders failed]]");
		});
	}
}
?>