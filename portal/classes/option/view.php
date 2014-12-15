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
		if($this->urlStatus() == "edit") {

			$this->sql(".edit", "classes", $this->xuId(), $f);
			$week_days = $this->sql(".edit.query", "classes", $this->xuId())->assoc("week_days");
			$week_days = preg_split("/\,/", $week_days);
			foreach ($f->week_days->child as $key => $value) {
				if(preg_grep("/". $value->attr['id'] ."/", $week_days)){
					$value->checked("checked");
				}
			}

			// exit();
		}
	}
}
?>