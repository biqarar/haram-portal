<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view {

	public function config(){
		//------------------------------ global
		$this->global->page_title ="classes";

		//------------------------------ load form
		$f = $this->form("@classes", $this->urlStatus());

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ list of teacher
		$list_teacher = $this->sql("#users_name_family");
		foreach ($list_teacher as $index => $child) {
			$f->teacher->child[] = $this->form("text")->label($child["name"]. ' ' . $child["family"])->value($child["users_id"]);
		}

		//------------------------------ edit form
		$this->sql(".edit", "classes", $this->xuId(), $f);
	}
}
?>