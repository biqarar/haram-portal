<?php
/**
* @author reza mohiti
*/
class model extends main_model {

	public function post_deleteapi(){
		$id = $this->xuId();
		$this->sql()->tablePermission()->whereId($id)->delete();
		$this->commit(function(){
			debug_lib::true("حذف سطح دسترسی انجام شد");
		});
		$this->rollback(function(){
			debug_lib::fatal("حذف سطح دسترسی با خطا مواجه شد");
		});
	}

	public function sql_find_username($users_id = false) {
		return $this->sql()->tableUsers()->whereId($users_id)->limit(1)->select()->assoc("username");
	}

	public function sql_find_users_id($username = false) {
		return $this->sql()->tableUsers()->whereUsername($username)->limit(1)->select()->assoc("id");
	}

	
	public function makeQuery() {
		//------------------------------ make sql object
		 return $this->sql()->tablePermission()
		 		// ->setTables(post::tables())
		 		->setUsers_id($this->sql_find_users_id(post::users_id()))
		 		->setSelect(post::select())
		 		->setUpdate(post::update())
		 		->setInsert(post::insert())
		 		->setDelete(post::delete())
		 		->setCondition(post::condition());
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