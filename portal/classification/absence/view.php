<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title = "absence";

		//------------------------------ absence tag
		$absence_tag = $this->tag("input")->type("text")->date("date")->addClass("absence-date");

		//------------------------------ get detail classes
		if(config_lib::$surl['classesid']){

			//------------------------------ classes id
			$classes_id = isset(config_lib::$surl['classesid']) ? config_lib::$surl['classesid'] : 0;
			$this->global->classesid = $classes_id;

			$classes_detail = $this->sql(".list" , "classes", function ($query) {
				$query->whereId(config_lib::$surl['classesid']);
			})->removeCol("type,name,status,start_time,end_time")

			//------------------------------ print link
			->addCol("print", "print")
			->select(-1, "print")
			->html($this->link("classification/printlist/classesid=%id%", "href" , "ico icoletters a-undefault"));

			//------------------------------ main date absence tag
			$main_absence_tag = $absence_tag->removeClass("absence-date")->addClass("absence-date-main");
			
			//------------------------------ main date absence col
			$classes_detail = $classes_detail->addCol("absenceDateMain", "absenceDateMain")->select(-1 , "absenceDateMain")
			->html($main_absence_tag);


			$classes_detail = $classes_detail->compile();
				
			//------------------------------ change users id to name and family to show
			$classes_detail = $this->detailClasses($classes_detail);
			

			$this->data->list = $classes_detail;
		}
		
		//------------------------------ list of person inserted in this class
		$classes_list =  $this->sql(".list", "classification", function($query , $classes_id){
			$query->whereClasses_id($classes_id);
		}, $classes_id)

		->removeCol("classes_id,plan_section_id,mark");


		//------------------------------ add absence col
		$checkbox = $this->tag("input")->type("checkbox")->addClass("absence-check");

		$classes_list = $classes_list->addCol("check", "check")
		->select(-1, "check")
		->html($checkbox);


		//------------------------------ add absence col
		$ss = $this->tag("input")->type("text")->date("date")->addClass("absence-date");

		$classes_list = $classes_list->addCol("absence", "absence")
		->select(-1, "absence")
		->html($ss);

		//------------------------------ add edit (classification) col
		$classes_list = $classes_list->addCol("edit", "edit")
		->select(-1, "edit")
		->html($this->editLink("classification"))


		->compile();

		//------------------------------ change users id to name and family to show
		if(isset($classes_list['list'])){	
			foreach ($classes_list ['list'] as $key => $value) {
				$classes_list ['list'][$key]['users_id'] = $this->sql(".username.get", $value['users_id']);
			}	
		}


		$this->data->classes_list = $classes_list;

		$this->data->classes_id = $this->data->list['list'][0]['id'];


	}
}
?>