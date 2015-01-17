<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config() {

		//------------------------------ global
		$this->global->page_title ="score";

		$this->global->score_type = $this->sql("#score_type", $this->xuId("scoretypeid"), "title");

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
		

		$this->data->dataTable = $this->dtable(
			"score/classes/status=apilist/classesid=" . $this->xuId("classesid")
			.'/scoretypeid=' . $this->xuId("scoretypeid") . "/",
			array("name", "family", "نمره " . $this->global->score_type));


		$this->data->classes_id = $this->data->list['list'][0]['id'];
	}
}
?>