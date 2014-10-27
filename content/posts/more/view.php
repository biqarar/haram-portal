<?php
class view extends main_view
{
	
	function config(){
		$this->global->page_title = "post more";
		$post = $this->sql(".list", "posts", function($query){
			$query->limit(20);
			
		})->compile();
		foreach ($post['list'] as $key => $value) {
			foreach ($value as $k => $v) {
				if($k == 'curl'){
					$post['list'][$key]['curl'] = preg_replace("/\s/", "-", $v);
				}
			}
		}
		$this->data->postsList= $post;
	}
}
?>