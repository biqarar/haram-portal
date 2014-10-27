<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){
		$this->global->page_title ="person";
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@person", $this->urlStatus());

		if($this->urlStatus() == "edit"){
			$this->global->page_title =_("person edit") .'  '. $this->xuId();
			$f->remove("casecode");
			$f->remove("casecode_old");

			// $f->remove("type");
			$f->remove("from");
			$f->remove("nationality");
			$f->remove("pasport_date");
			$this->sql(".edit", "person", $this->xuId(), $f);
		}
	}
}
?>