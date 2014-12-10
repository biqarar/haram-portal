<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'branch';

		//------------------------------ load form
		$f = $this->form("@branch", $this->urlStatus());

		//------------------------------ list of branch
		$list = $this->sql(".list","branch");
		$list = $this->editCol("branch" ,$list, $this->editLink("branch"));

		$this->data->list = $list->compile();
		//------------------------------ edit form
		$this->sql(".edit", "branch", $this->xuId(), $f);
	}

	public function editCol($table, $list, $html) {
		if($this->colPermission($table, "update")) {
			return	$list->addCol("edit", "edit")->select(-1, "edit")->html($html);
		}else{
			return $list;
		}
	}

	public function colPermission($table, $operat) {
		if(isset($_SESSION['user_permission']['tables'][$table][$operat]) && 
			$_SESSION['user_permission']['tables'][$table][$operat] == 'public'){
			return true;
		}
		return false;
	}
}
?>