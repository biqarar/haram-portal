<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class model extends main_model{

	public function post_insertapi() {
		$classificationid = $this->xuId("classificationid");
		var_dump($classificationid);
		exit();
	}
	
	public function makeQuery() {
		//------------------------------ make object sql
		return $this->sql()->tableCertification()
				->setName(post::name())
				->setMulticlass(post::multiclass())
				->setBranch_id(post::branch_id())
				->setDescription(post::description());
	}

	public function post_add_certification() {

		//------------------------------ check duplicate entry
		$duplicate = $this->sql()->tablecertification()->whereName(post::name())->andBranch_id(post::branch_id())->select()->num();

		if($duplicate >= 1){
			$this->rollback(function() {
				debug_lib::fatal("[[duplicate entry for name]]");
			});
		}else{
			//------------------------------ insert certification
			$sql = $this->makeQuery()->insert();
		}

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert certification successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert certification failed]]");
		});
	}

	public function post_edit_certification() {

		//------------------------------ update certification
		$sql = $this->makeQuery()->whereId($this->xuId())->update();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update certification successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[update certification failed]]");
		});
	}
}
?>