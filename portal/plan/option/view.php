<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->global->page_title ="plan";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@plan", $this->uStatus());
		$this->listBranch($f);
		$this->sql(".edit", "plan", $this->uId(), $f);
		$this->data->list = $this->sql(".list","plan")->compile();
		
	}
}
?>