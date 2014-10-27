
<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->global->page_title ="teachinghistory";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@teachinghistory", $this->uStatus());

		$this->sql(".edit", "teachinghistory", $this->uId(), $f);
	}
}
?>