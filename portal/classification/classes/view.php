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
			$classes_id = config_lib::$surl['classesid'];

			$c = $this->sql(".list" , "classes", function ($query) {
				$query->whereId(config_lib::$surl['classesid']);
			});
			//------------------------------ remove col
			$c->removeCol("meeting_no,age_range,quality,start_date,end_date");
				$this->data->list = $c->compile();
		}
		
		//------------------------------ list of person inserted in this class
		$classes_list =  $this->sql(".list", "classification", function($query){
			$query->whereClasses_id($classes_id);
		})->compile();

		//------------------------------ change users id to name and family to show
		if(isset($classes_list['list'])){	
			foreach ($classes_list ['list'] as $key => $value) {
				$classes_list ['list'][$key]['name'] = $this->sql(".username.get", $value['users_id']);
			}	
		}

		//------------------------------ search form
		$hidden = $this->form("#hidden")->value("xsearch");
		$searchF = $this->form("text")->name("search")->label("search");
		$submit = $this->form("submit")->value("search");
		$search = array();
		$search[] = $hidden->compile();
		$search[] = $searchF->compile();
		$search[] = $submit->compile();
		$this->data->search = $search;

		//------------------------------ detail person link
		$c = $this->tag("a")->addClass("xmore")
		->attr("href", "users/status=detail/id=%users_id%")
		->attr("target", "_blank");

		//------------------------------ classification link
		$classification = $this->tag("a")->text("ثبت در کلاس")
		->attr("href", "classification/api/usersid=%users_id%/classesid=" . $classes_id)
		->attr("target", "_blank");
		
		//------------------------------ seach into person table
		$person = $this->sql("#s_search");
		$person->addCol("detail","more")
			->select(-1, "detail")->html($c)
			->addCol("classification","کلاس بندی")
			->select(-1, "classification")->html($classification)
			->removeCol(
			"id,from,City_id,record_id,Absence_dateEducation_id,Education_group,Country_id,country,province_id,
			casecode,casecode_old,type,en_name,en_family,en_father,third_name,third_family,
			third_father,pasport_date,users_id,group,id,child,nationality,City_province_id");	

		$this->data->person = $person->compile();


		$this->data->classes_list = $classes_list;

		$this->data->classes_id = $this->data->list['list'][0]['id'];
	}
}
?>