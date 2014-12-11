<?php
class view extends main_view
{
	
	function config(){
		$data = $this->sql(".postsList", $this->uId(1), 5);
		$this->global->page_title = $data['title'];
		$this->data->posts = $data['list'];
	}
}
?>