<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {
	
	public function post_api() {
	

		// $dtable = new dtable;
		// $dtable->table('person')
		// 	->fields('name', 'family', 'father', 'birthday', 'gender', 'nationalcode', 'code', 'marriage', 'education_id', 'id detail', 'id edit', 'users_id')
		// 	->search_fields('name', 'family', 'father')
		// 	->result(function($r){
		// 		$r->detail = '<a class="icomore ui-draggable ui-draggable-handle" href="users/status=detail/id='.$r->detail.'" title="'.gettext('detail').' '.$r->detail.'"></a>';
		// 		$r->edit = '<a class="icoedit ui-draggable ui-draggable-handle" href="person/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';
		// 	});
		// $this->sql(".dataTable", $dtable);
	}


	public function makeQuery() {
		//------------------------------ make sql object
		return $this->sql()->tableBranch()->setName(post::name())->setGender(post::gender());
	}

	public function post_add_branch() {
		//------------------------------ insert branch
		$sql = $this->makeQuery()->insert();

		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[insert branch successful]]");
		});

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert branch failed]]");
		});
	}

	public function post_edit_branch() {
		//------------------------------ update branch
		$sql = $this->makeQuery()->whereId($this->xuId())->update();
		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update branch successful]]");
		});

		//------------------------------ update code
		$this->rollback(function() {
			debug_lib::fatal("[[update branch failed]]");
		});
	}

}
?>