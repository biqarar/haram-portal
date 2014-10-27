<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view{
	public function config(){
		$this->global->page_title ="classification";
		$c = $this->sql(".list" , "classes", function ($query) {
			$query->whereId($this->uId(1));
		});
		$c->removeCol("meeting_no,age_range,quality,start_date,end_date");
		$this->data->list = $c->compile();
		$classes_list =  $this->sql(".list", "classification", function($query){
			$query->whereClasses_id(config_lib::$aurl[1]);

		// 	$query->foreignUsers_id();
		// 	// var_dump($query);
		// 	// $query->foreignClasses_id();
		// 	// var_dump($query);
		})->removeCol("Users_email, email, id, status,classes_id,Users_id, plan_section_id,Users_username, Users_password, username, password")
		->addColFirst("name", "name")
		->compile();
		if(isset($classes_list['list'])){	
			foreach ($classes_list ['list'] as $key => $value) {
				$classes_list ['list'][$key]['name'] = $this->sql(".username.get", $value['users_id']);
			}	
		}
		// var_dump($classes_list);
		// exit();
		///////////////////////////////////////////
		$this->global->url  = (isset(config_lib::$aurl[1]))? config_lib::$aurl[1]: 0;

		$hidden = $this->form("#hidden")->value("xsearch");
		$searchF = $this->form("text")->name("search")->label("search");
		$submit = $this->form("submit")->value("search");
		$search = array();
		$search[] = $hidden->compile();
		$search[] = $searchF->compile();
		$search[] = $submit->compile();
		$this->data->search = $search;

		$c = $this->tag("a")
		// ->text("more")
		->addClass("xmore")
		->attr("href", "users/status=detail/id=%users_id%")
		->attr("target", "_blank");

		$classification = $this->tag("a")
		->text("ثبت در کلاس")
		// ->addClass("xmore")
		->attr("href", "classification/api/%users_id%/" . $this->uId(1))
		->attr("target", "_blank");
		$person = $this->sql("#s_search");
		$person->addCol("detail","more")
			->select(-1, "detail")->html($c)
			->addCol("classification","کلاس بندی")
			->select(-1, "classification")->html($classification)
			->removeCol(
			"id,from,City_id,record_id,Absence_dateEducation_id,Education_group,Country_id,country,province_id,
			casecode,casecode_old,type,en_name,en_family,en_father,third_name,third_family,
			third_father,pasport_date,users_id,group,id,child,nationality,City_province_id");	
		// var_dump($person->compile());
		$this->data->person = $person->compile();
		//////////////////////////////////////////
		$this->data->classes_list = $classes_list;
		$this->data->classes_id = $this->data->list['list'][0]['id'];
		// var_dump($this->data->list);
	}
}
?>