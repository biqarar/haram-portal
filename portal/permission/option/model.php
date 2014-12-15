<?php
/**
* @author reza mohiti
*/
class model extends main_model {

	public function makeQuery() {
		//------------------------------ make sql object
		 return $this->sql()->tablePermission()
		 		// ->setTables(post::tables())
		 		->setUsers_id(post::users_id())
		 		->setSelect(post::select())
		 		->setUpdate(post::update())
		 		->setInsert(post::insert())
		 		->setDelete(post::delete());
	}

	public function post_add_permission(){
		//------------------------------ insert permission
		foreach ($_POST as $key => $value) {
			if(preg_match("/^table\_(.*)/", $key)) {
				$sql = $this->makeQuery()->setTables($value)->insert();
			}
		}

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert permission successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert permission failed]]");
		});
	}

	public function post_edit_permission() {
		//------------------------------ update permisson
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update permission successful]]");
		});

		//------------------------------ roolback code
		$this->rollback(function() {
			debug_lib::fatal("[[update permission failed]]");
		});
	}
}
 ?>