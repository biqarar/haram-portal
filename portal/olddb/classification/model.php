<?php 
/**
* 
*/
class model extends main_model
{
	public function sql_oldclasses_detail($oldclasses) {
		$detail =  $this->sql()->tableOldclasses()->whereCode($oldclasses)->limit(1)->select()->assoc();
		return $detail['dore'] . " , " . $detail['maqta'] . " , " . $detail['teacher'];

	}
}
?>