<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'change password';
		$hidden = $this->form("#hidden")->value("changepasswd");
		$oldpasswd = $this->form("password")->name("oldpasswd")->label("oldpasswd");
		$newpasswd = $this->form("password")->name("newpasswd")->label("newpasswd");
		$repasswd =  $this->form("password")->name("repasswd")->label("repasswd");
		$submit = $this->form("#submitedit")->value("update");
		$changepasswd = array();
		$changepasswd[] = $hidden->compile();
		$changepasswd[] = $oldpasswd->compile();
		$changepasswd[] = $newpasswd->compile();
		$changepasswd[] = $repasswd->compile();
		$changepasswd[] = $submit->compile();
		$this->data->changepasswd = $changepasswd;
	}
}
?>