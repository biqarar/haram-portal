<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class model extends main_model{

	public function post_insertapi() {
		$classificationid = $this->xuId("classificationid");

		// $mark = $this->sql()->tableClassification()->whereId($classificationid)->limit(1)->select();
		$duplicate = $this->sql()->tableCertification()->whereClassification_id($classificationid)
			->limit(1)->select()->num();

		if($duplicate == 0 ) {
			$x = $this->sql()->tableCertification()
				->setClassification_id($classificationid)
				->setDate_request($this->dateNow())
				->insert();
				// var_dump($x);exit();
				debug_lib::true("گواهی نامه با موفقیت ثبت شد");
		}elseif($duplicate != 0 ){
			debug_lib::fatal("این گواهی نامه قبلا ثبت شده است");
		}else{
			debug_lib::fatal("ثبت گواهی نامه با خطا مواجه شده است");
		}
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