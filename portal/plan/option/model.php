<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class model extends main_model{
	
	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()->tablePlan()
				->setGroup_id(post::group_id())
				->setName(post::name())
				->setPrice(post::price())
				->setAbsence(post::absence())
				->setCertificate(post::certificate())
				->setMark(post::mark())
				// ->setRule(post::rule())
				->setMin_person(post::min_person())
				->setMax_person(post::max_person());
	}

	public function post_add_plan() {
		//------------------------------ insert plan
		$sql = $this->makeQuery()->insert();

		// print_r($sql->string());

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert plan successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert plan failed]]");
		});
	}

	public function post_edit_plan() {

		//------------------------------ update paln
		$sql = $this->makeQuery()->whereId($this->xuId())->update();
		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update plan successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update plan failed]]");
		});
	}
}
?>