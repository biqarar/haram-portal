<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		//------------------------------  global
		$this->global->page_title = _("پرونده تحصیلی") . " " . _("student");

		//------------------------------  set users_id
		$users_id  = $this->xuId();

		//------------------------------ check users (if teacher , can not be display another users by id)
		$this->check_users_type($users_id);

		//------------------------------  make classification card
		$price_list = $this->sql("#price_list" , $users_id);

		$price["titleLink"]= "price/status=list"; 

		$sum_active = $this->tag("a")
			->style("text-decoration: none")
			->vtext("موجودی فعال")
			->render();
		$price["list"]['list'][0][$sum_active] = $price_list['sum_active'];
		
		$sum_all = $this->tag("a")
			->href("users/learn/classes/id=" . $users_id)
			->style("text-decoration: none")
			->vtext("مجموع مبالغ ‍پرداخت شده")
			->render();
		$price["list"]['list'][0][$sum_all] = $price_list['sum_all'];

		$sum_low = $this->tag("a")
			->href("users/learn/classes/id=" . $users_id)
			->style("text-decoration: none")
			->vtext("مجموع مبالغ کسر شده")
			->render();
		$price["list"]['list'][0][$sum_low] = $price_list['sum_low'];

		$count_transaction = $this->tag("a")
			->style("text-decoration: none")
			->vtext("تعداد تراکنش")
			->render();
		$price["list"]['list'][0][$count_transaction] = $price_list['count_transaction'];


		//------------------------------  global of price card
		$price['title'] = "price";
		$price["moreLink"] = "price/status=detail/usersid=$users_id";
		$price['addLink'] = "price/status=add/usersid=$users_id";
		$this->data->price = $price;


		//------------------------------  make classification card
		$classification_list = $this->sql("#classification_list" , $users_id);

		//------------------------------  all classes tag
		$all_classes = $this->tag("a")
			->href("users/learn/classes/id=" . $users_id)
			->style("text-decoration: none")
			->vtext("تعداد کل کلاس ها")
			->render();
		$classification["list"]['list'][0][$all_classes] = $classification_list['sum_all'];

		//------------------------------  active classes tag
		$active_classes = $this->tag("a")
			->style("text-decoration: none")
			->vtext("تعداد کلاس های فعال")
			->render();
		$classification["list"]['list'][0][$active_classes] = $classification_list['sum_active'];

		//------------------------------  list of active classes
		foreach ($classification_list['classes'] as $key => $value) {
			$i_classes = $key;
			$i_absence = $key;
			//------------------------------  lable active classes tag
			$classes_title = $this->tag("a")
				->href("classification/class/classesid=". $classification_list['classes'][$key]['id'])
				->style("text-decoration: none")
				->vtext(" کلاس شماره  "  . ++$i_classes)
				->render();

			//------------------------------  label detail classes tag
			$classes_value = $this->tag("a")
				->href("classes/status=detail/id=". $classification_list['classes'][$key]['id'])
				->style("text-decoration: none")
				->vtext($value['string'])
				->render();


			//------------------------------ absence
			$absence_title = $this->tag("a")
				->href("classes/status=detail/id=". $classification_list['classes'][$key]['id'])
				->style("text-decoration: none")
				->vtext(" کلاس شماره  "  . ++$i_absence)
				->render();


			//------------------------------   list of active classes
			$classification["list"]['list'][0][$classes_title] = $classes_value;

		}

		//------------------------------  global of classification card
		$classification['title'] = "classification";
		$classification['titleLink'] = "classes/status=list/type=classification";
		// $classification["moreLink"] = "classification/status=detail/usersid=$users_id";
		
		$this->data->classification = $classification;

		//------------------------------  make olddb card
		$this->data->olddb = $this->sql(".olddb", $users_id);


		//------------------------------  make classification card
		$score['title'] = "پرونده تحصیلی";
		$score['list']['list'][0]["غیبت و نمرات"] = $this->tag("a")->href("users/learn/status/id=". $users_id)
		->vtext("نمایش اطلاعات")->render();
		$this->data->score = $score;


		$this->data->dataTable = $this->dtable(
			"users/learn/status/status=apilist/id=" . $this->xuId() . "/", 
			array("id"
			, "plan"
			, "teachername"
			,"teacherfamily"
			,"date_entry"
			,"date_delete"
			,"because"
			, "تعداد غیبت"
			, "امتیاز نهایی"
			, "certification"));
		$certification = array();
		$list_certification = $this->sql("#find_list_certification", $users_id);
		foreach ($list_certification as $key => $value) {
		$certification['title'] = "certification";
		$certification['list']['list'][0][" دوره " . $value['planname']] = $this->tag("a")
		->style("text-decoration: none")
		->href("")
		->class("insert-certification")
		->classificationid($value['id'])
			->vtext("ثبت گواهی نامه با امتیاز " . $value['mark'])->render();
		}
		// var_dump($certification);exit();
		$this->data->certification = !empty($certification) ? $certification : false;
	}
} 
?>