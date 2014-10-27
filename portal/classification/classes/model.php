<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {
	
	
	
	public function post_edit_classification() {
		$sql = $this->makeQuery()->whereId($this->uId())->update();
		$this->commit(function() {
			debug_lib::true("[[update classification successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update classification failed]]");
		});
	}

		public function post_xsearch() {
		$text = post::search();
		$_SESSION['text_search'] = $text;
	}

	public function sql_s_search($query = false) {
		// "concat(name, ' ', family , ' ' , father)"
		$family = false;
		$search = isset($_SESSION['text_search'])? $_SESSION['text_search'] : false;
		if(preg_match("/\s{2}/", $search)){
			$search = preg_split("/\s{2}/", $search);
		}
		
			$person = $this->sql(".list", "person", function ($query, $search){
				$query->limit(30);
				if($search && !is_array($search)){
					$query->whereName("like", "%". $search . "%")->orFamily("like", "%". $search . "%");
				}elseif(is_array($search)){
					if(isset($search[2])){
						$query->whereName("like", "%". $search[0] . "%")->andFamily("like", "%". $search[1] . "%")->andFather("like", "%". $search[2] . "%");
					}else{
						$query->whereName("like", "%". $search[0] . "%")->andFamily("like", "%". $search[1] . "%");
					}
				}
			}, $search);
		return $person;
	}
}
?>