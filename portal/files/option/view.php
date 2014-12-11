<?php
/**
 * @author REZA MOHITI <rm.biqarar@gmail.com>
 */

class view extends main_view{
	public function config(){
		$this->global->page_title='files';
		$this->global->url = $this->uStatus(true);
		$f = $file = $this->sql(".files.form", $this);
		$this->sql(".edit", "files", $this->uId(), $f);


	}
}
?>