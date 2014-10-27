<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title ="classes";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@classes", $this->uStatus());
		$list_teacher = $this->sql("#users_name_family");
		foreach ($list_teacher as $index => $child) {
			$f->teacher->child[] = $this->form("text")->label($child["name"]. ' ' . $child["family"])->value($child["users_id"]);
		}
		$this->listBranch($f);
		$this->sql(".edit", "classes", $this->uId(), $f);
	}
}
?>