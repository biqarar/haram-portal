<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		
		// var_dump($this->uId(1));exit();
		$this->data->posts = $this->sql(".postsList", $this->xuId(1), 5);
		
		// // $this->global->page_title = $data['title'];
		// foreach ($data as $key => $value) {
		// 	foreach ($value as $k => $v) {
		// 		var_dump($k, $v);
		// 		if($k == "curl"){
		// 			$data['list'][$key]["curl"] = preg_replace("/\s/", "-", $v);
		// 		}
		// 	}
		// }
		//  $this->data->posts = $data['list'];
	}
}
?>