<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'select branch';
// var_dump("Fucffff");
		$f = $this->form("@users_branch");
		$f->add("hidden", "hidden")->name("_post")->value("selectbranch");
		// var_dump($this->sql(".branch.get_users_branch"));exit();
		foreach ($this->sql(".branch.get_users_branch") as $key => $value) {
			$f->add("select_branch_". $value['branch_id'], "submit")
			->name("selectbranch_" .  $value['branch_id'])
			->value(_($value['type']) . " در " . $value['name'])
			->id($value['branch_id'])
			// ->value()
			->label("ورود به عنوان");
			
		}
			$f->add("logout","submit")
			->name("logout")
			->value(_("logout"))
			->label("خروج");
		
		$f->remove("submit");
	}
}
?>