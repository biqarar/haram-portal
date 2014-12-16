<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="classification";

		//------------------------------ get detail classes
		if(config_lib::$surl['classesid']){
			//------------------------------ classes id
			$classes_id = isset(config_lib::$surl['classesid']) ? config_lib::$surl['classesid'] : 0;
			$this->global->classesid = $classes_id;

			$classes_detail = $this->sql(".list" , "classes", function ($query) {
				$query->whereId(config_lib::$surl['classesid']);
			})->removeCol("meeting_no,start_date,end_date")

			//------------------------------ print link
			->addCol("print", "print")
			->select(-1, "print")
			->html($this->link("classification/printlist/classesid=%id%", "href" , "icoletters a-undefault"))

			->compile();
			
			//------------------------------ change users id to name and family to show
			$classes_detail = $this->detailClasses($classes_detail);
			
			$this->global->page_title = gettext("class").' '.
			$classes_detail['list'][0]['plan_id'] . ' استاد ' .
			$classes_detail['list'][0]['teacher'] . ' ' .
			$classes_detail['list'][0]['place_id'] ;
			// var_dump($classes_detail);
			// die();

			$this->data->list = $classes_detail;
		}
		
		//------------------------------ list of person inserted in this class
		// $classes_list =  $this->sql(".list", "classification", function($query , $classes_id){
		// 	$query->whereClasses_id($classes_id);
		// }, $classes_id)
		// ->addCol("edit", "edit")
		// ->select(-1, "edit")
		// ->html($this->editLink("classification"))
		// ->compile();

		$this->data->dataTable = $this->dtable("classification/status=api/classesid=" . $this->xuId("classesid").'/',
			array("name", "family", "date_entry", "date_delete", "because", "edit"));

		// //------------------------------ change users id to name and family to show
		// if(isset($classes_list['list'])){	
		// 	foreach ($classes_list ['list'] as $key => $value) {
		// 		$classes_list ['list'][$key]['users_id'] = $this->sql(".username.get", $value['users_id']);
		// 	}	
		// }


		// $this->data->classes_list = $classes_list;

		$this->data->classes_id = $this->data->list['list'][0]['id'];
	}
}
?>