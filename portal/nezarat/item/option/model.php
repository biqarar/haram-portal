<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class model extends main_model{
	
	public function makeQuery() {
	
		//------------------------------ make sql object
		return $this->sql()->tableNezarat_item()
				->setTitle(post::title())
				->setValidation(post::validation())
				->setGroup(post::group())
				->setDescription(post::description());
	}

	public function post_add_nezarat_item() {
		//------------------------------ check duplicate nezarat_item
		// $this->check_duplication("insert");

		//------------------------------ insert nezarat_item
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert nezarat_item successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert nezarat_item failed]]");
		});
	}

	public function post_edit_nezarat_item() {


		//------------------------------ check duplicate nezarat_item
		// $this->check_duplication("update");

		//------------------------------ update nezarat_item
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update nezarat_item successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update nezarat_item failed]]");
		});
	}
}
?>