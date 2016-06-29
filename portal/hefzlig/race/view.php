<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		
		//------------------------------ globals
		$this->global->page_title = 'race';
		// var_dump("fuck");exit();
		$f = $this->form("@hefz_race", $this->urlStatus());
		$this->sql(".edit", "hefz_race", $this->xuId(), $f);
		
		$this->data->dataTable = $this->dtable(
			"hefzlig/race/status=listapi/", 
			array('id','ligs', 'تیم اول','تیم دوم','type','description', "نتیجه","edit","delete", "مسابقه"));
	
	}

}
?>