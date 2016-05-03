<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {
	
	// public function post_xsearch() {
		
	// 	//------------------------------ text for search
	// 	$text = post::search();

	// 	//------------------------------ set into $_SESSION because to other function get it (sql_s_search())
	// 	$_SESSION['text_search'] = $text;
	// }

	// public function sql_s_search($query = false) {
	// 	//------------------------------ concat field for search but now not run !@#$
	// 	// "concat(name, ' ', family , ' ' , father)"

	// 	//------------------------------ if isset \s{2} in the search text split and search into name and famil (father too)
	// 	$family = false;
	// 	$search = isset($_SESSION['text_search'])? $_SESSION['text_search'] : false;
	// 	if(preg_match("/\s{2}/", $search)){
	// 		$search = preg_split("/\s{2}/", $search);
	// 	}
		
	// 	//------------------------------ list of person where search
	// 	$person = $this->sql(".list", "person", function ($query, $search){
			
	// 		$query->limit(30);
			
	// 		if($search && !is_array($search)){
				
	// 			$query->whereName("like", "%". $search . "%")->orFamily("like", "%". $search . "%");

	// 		}elseif(is_array($search)){

	// 			if(isset($search[2])){
				
	// 				$query->whereName("like", "%". $search[0] . "%")->andFamily("like", "%". $search[1] . "%")->andFather("like", "%". $search[2] . "%");
				
	// 			}else{
				
	// 				$query->whereName("like", "%". $search[0] . "%")->andFamily("like", "%". $search[1] . "%");
	// 			}
	// 		}
	// 	}, $search);
	// 	return $person;
	// }

	// public function sql_if_registerd($classes_id = false) {
	// 	return $this->sql()->tableClassification()->whereClasses_id($classes_id)->select()->allAssoc("users_id");

	// }
}
?>