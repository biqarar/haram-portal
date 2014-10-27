<?php
class view extends main_view
{
	
	function config(){
		$this->global->page_title = "post more";
		$post = $this->sql(".list", "posts", function($q){
			$q->whereCurl(preg_replace("/\-/", " ", config_lib::$aurl[0]))->limit(1);
		});
		// var_dump($post);
		$this->data->postsList= $post->compile();
	
	}
}
?>