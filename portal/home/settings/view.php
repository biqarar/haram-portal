<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'settings';
		
		//------------------------------ make chane password form
		$settings = array();
		$settings[] = $this->form("#hidden")->value("settings")->compile();
		foreach ($_SESSION['users_branch'] as $key => $value) {
			$x = $this->form("checkbox")
					->name("branch_" . $value)
					->label($this->sql("#branch_name", $value));
			if(isset($_SESSION['branch_active']) && preg_grep("/^" . $value. "$/", $_SESSION['branch_active'])){
				$x->checked("checked");
			}
			$settings[] = $x->compile();
		}

		$settings[] = $this->form("#submitedit")->value("update")->compile();

		$this->data->settings = $settings;
	}
}
?>