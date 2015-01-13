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
			->html($this->link("classification/printlist/classesid=%id%", "href" , "icoletters a-undefault"));

			//------------------------------ main date absence tag
			$main_absence_tag = $absence_tag->removeClass("absence-date")->addClass("absence-date-main");
			
			//------------------------------ main date absence col
			$classes_detail = $classes_detail->addCol("date", "date")->select(-1 , "date")
			->html($main_absence_tag);


			$classes_detail = $classes_detail->compile();
			
			//------------------------------ change users id to name and family to show
			$classes_detail = $this->detailClasses($classes_detail);
			

			$this->data->list = $classes_detail;
		}
			

			$this->data->dataTable = $this->dtable("absence/status=classeslist/classesid=" . $this->xuId("classesid").'/',
			array("name", "family", "date_entry", "date_delete", "because" ,"ثبت غیبت" , "ثبت غیبت بیشتر"));

		$this->data->classes_id = $this->data->list['list'][0]['id'];


	}
}
?>