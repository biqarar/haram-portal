<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		$this->global->page_title = "users_detail";
		$users_detail = $this->sql("#users_detail", $this->xuId());
		$users_id  = $this->xuId();
		$this->data->person = $this->sql(".list.card", "person", $users_id);
		$this->data->bridge = $this->sql(".list.card" , "bridge", $users_id, "users_id");
		
		

	}
} 
?>