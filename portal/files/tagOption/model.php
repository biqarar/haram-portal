<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function post_api() {
		$dtable = $this->dtable->table("file_tag")
		->fields("id", "tag", "table_name", "id edit")
		->search_fields("tag")
		->result(function($r){
			// $r->edit = '<a href="country/status=edit/id=' . $r->edit . '" class="icoedit" ></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()->tableFile_tag()->setTag(post::tag())->setTable_name(post::table_name());
	}

	public function post_add_file_tag(){
		//------------------------------ insert country
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert tag successful]]");
		});

		//------------------------------ rolback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert tag failed]]");
		});
	}

	public function post_edit_file_tag(){
		//------------------------------ update country
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update tag ture]]");
		});

		//------------------------------ rolback code
		$this->rollback(function() {
			debug_lib::fatal("[[update tag failed]]");
		});
	}
}
?>