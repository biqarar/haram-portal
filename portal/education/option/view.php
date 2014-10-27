<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/
class view extends main_view{
	public function config(){
		$this->global->page_title = "education";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@education", $this->uStatus());

		$this->sql(".edit", "education", $this->uId(), $f);
		
		$this->data->list = $this->sql(".list","education")->compile();

	}
}
?>