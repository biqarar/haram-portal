<?php
/**
* @author reza mohiti
*/
class model extends main_model {

	public function sql_tables_list() {
		// var_dump(opendir(sql));
	}

	public function makeQuery() {
		 return $this->sql()->tablePermission()
		 		->setTables(post::tables())
		 		->setUsers_id(post::users_id())
		 		->setSelect(post::select())
		 		->setUpdate(post::update())
		 		->setInsert(post::insert())
		 		->setDelete(post::delete());
	}

	public function post_add_permission(){
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert permission successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert permission failed]]");
		});
	}

	public function post_edit_permission() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update permission successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update permission failed]]");
		});
	}
}
 ?>