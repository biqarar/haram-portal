<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class model extends main_model{

	public function makeQuery() {
		return $this->sql()->tableRacehistory()
				->setUsers_id(post::users_id())
				->setField(post::field())
				->setClub(post::club())
				->setStep(post::step())
				->setRank(post::rank())
				->setYear(post::year());
	}

	public function post_add_racehistory(){
		$sql = $this->makeQuery()->insert();
		$this->commit(function() {
			debug_lib::true("[[insert racehistory successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[insert racehistory failed]]");
		});
	}

	public function post_edit_racehistory(){
		$sql = $this->makeQuery()
				->whereId($this->uId())
				->update();
		$this->commit(function() {
			debug_lib::true("[[update racehistory ture]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update racehistory failed]]");
		});
	}
}
?>