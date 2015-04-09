<?php
class query_postsList_cls extends query_cls
{
	
	public function config($posts_id = false, $limit = false) {
		// var_dump($posts_id);exit();
		$posts = $this->sql()->tablePosts();
		$return = array();
		if($posts_id) {
			$posts->whereId($posts_id);
		}
		if($limit) {
			$posts->limit($limit);
		}
		$returnPosts = $posts->select()->allAssoc();
		foreach ($returnPosts as $key => $value) {
			$pic_id = $this->sql()->tableTable_files()->whereTable("posts")->andRecord_id($value['id'])->select()->assoc();
			$files = $this->sql()->tableFiles()->whereId($pic_id['files_id'])->select()->allAssoc();
			$addres = array();
			foreach ($files as $k => $v) {
				$addres[] = $v['folder'] . '/'. $v['id'] . '.' . $v['type'];
			}
			$return['list'] = $returnPosts;
		}
		if($posts_id) {
			$return['title'] = $returnPosts[0]['title'];
			array_push($returnPosts[$key], array("pic" => $addres));
		}else{
			$return['title'] = 'مرکز قرآن و حدیث';
		}
		return $return;
		// return $returnPosts;
	}
}
?>