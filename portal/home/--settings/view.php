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
		foreach ($_SESSION['user']['branch'] as $key => $value) {
			$x = $this->form("checkbox")
					->name("branch_" . $value)
					->label($this->sql("#branch_name", $value));
			if(isset($_SESSION['user']['branch']['active']) && preg_grep("/^" . $value. "$/", $_SESSION['user']['branch']['active'])){
				$x->checked("checked");
			}
			$settings[] = $x->compile();
		}

		$settings[] = $this->form("#submitedit")->value("update")->compile();

		$this->data->settings = $settings;
	}
}
?>