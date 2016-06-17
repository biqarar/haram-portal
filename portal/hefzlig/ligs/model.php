<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_listapi(){
		$dtable = $this->dtable->table("hefz_ligs")
		->fields('id', 'start_date', 'end_date','name',  "id edit")
		->search_fields("name")
		->result(function($r) {
			$r->edit = '<a class="icoedit" href="hefzlig/ligs/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		});
		$this->sql(".dataTable", $dtable);
	}

	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()
			->tableHefz_ligs()
			->setName(post::name())
			->setStart_date(post::start_date())
			->setEnd_date(post::end_date())
			->setBranch_id($this->post_branch());
	}

	public function post_add_hefz_ligs() {
		//------------------------------ insert ligs
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert ligs successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert ligs failed]]");
		});
	}

	public function post_edit_hefz_ligs() {
		//------------------------------ update ligs
		$sql = $this->makeQuery()->whereId($this->xuId())->update();
		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update ligs successful]]");
		});

		//------------------------------ update code
		$this->rollback(function() {
			debug_lib::fatal("[[update ligs failed]]");
		});
	}

}
?>