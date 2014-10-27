<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		
		$data = $this->sql(".postsList", $this->uId(1), 5);
		$this->global->page_title = $data['title'];
		foreach ($data['list'] as $key => $value) {
			foreach ($value as $k => $v) {
				if($k == "curl"){
					$data['list'][$key]["curl"] = preg_replace("/\s/", "-", $v);
				}
			}
		}
		 $this->data->posts = $data['list'];
	}
}
?>