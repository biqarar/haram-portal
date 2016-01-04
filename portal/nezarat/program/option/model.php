<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */
class model extends main_model{
	
	public function makeQuery() {
	
		//------------------------------ make sql object
		return $this->sql()->tableNezarat_program()
				->setTitle(post::title())
				->setParent(post::parent())
				->setDescription(post::description());
	}

	public function post_add_nezarat_program() {

		//------------------------------ insert nezarat_program
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert nezarat_program successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert nezarat_program failed]]");
		});
	}

	public function post_edit_nezarat_program() {


		//------------------------------ update nezarat_program
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update nezarat_program successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update nezarat_program failed]]");
		});
	}
}
?>