<?php
class view extends main_view{
	function config(){

		// $tag = $this->tag("b");
		// $tag->text("%Province_id%");
		// // var_dump($tag->compile());
		// // exit();
		// $list = $this->sql(".list", "city", function($query, $x){
		// 	$query
		// 	->foreignProvince_id();
		// }, 10)
		// // ->removeCol("name")
		// ->col("Province_id")
		// ->html("<b>%Province_id%</b>")
		// ->col('Province_name', 'نام استان');
		// // var_dump($list);
		// $list = $this->sql(".list", "city", function($query) {
		// 	$query->joinProvince()->whereTable("Province")->andProvince_id("#city.id");
		// });
		
		// $this->data->list = $list->compile();
	}
}
?>