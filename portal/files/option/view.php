<?php
/**
 * @author REZA MOHITI <rm.biqarar@gmail.com>
 */

class view extends main_view{
	public function config(){
		$this->global->page_title='files';
		$this->global->url = $this->uStatus(true);
		$hidden = $this->form("#hidden")->value("files");
		$oldpasswd = $this->form("password")->name("oldpasswd")->label("oldpasswd");
		$newpasswd = $this->form("password")->name("newpasswd")->label("newpasswd");
		$repasswd =  $this->form("password")->name("repasswd")->label("repasswd");
		$submit = $this->form("#submitedit")->value("update");
		
		$files = array();
		
		$files[] = $hidden->compile();
		$files[] = $oldpasswd->compile();
		$files[] = $newpasswd->compile();
		$files[] = $repasswd->compile();
		$files[] = $submit->compile();
		
		$this->data->files = $files;
	}
}
?>