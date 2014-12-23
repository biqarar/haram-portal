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

		// classification
		// price
		// absence
		// certification

		//------------------------------  make classification card
		$classification_list = $this->sql("#classification_list" , $users_id);

		//------------------------------  all classes tag
		$all_classes = $this->tag("a")
			->href("users/status=learn/type=classes/id=" . $users_id)
			->style("text-decoration: none")
			->vtext("تعداد کل کلاس ها")
			->render();
		$classification["list"]['list'][0][$all_classes] = $classification_list['sum_all'];

		//------------------------------  active classes tag
		$active_classes = $this->tag("a")
			// ->href("sdsdfsdfsdfdsf")
			->style("text-decoration: none")
			->vtext("تعداد کلاس های فعال")
			->render();
		$classification["list"]['list'][0][$active_classes] = $classification_list['sum_active'];

		//------------------------------  list of active classes
		foreach ($classification_list['classes'] as $key => $value) {
			$i = $key;
			//------------------------------  lable active classes tag
			$c = $this->tag("a")
				->href("classes/status=detail/id=". $classification_list['classes'][$key]['id'])
				->style("text-decoration: none")
				->vtext(" کلاس شماره  "  . ++$i)
				->render();

			//------------------------------  label detail classes tag
			$v = $this->tag("a")
				->href("classes/status=detail/id=". $classification_list['classes'][$key]['id'])
				->style("text-decoration: none")
				->vtext($value['string'])
				->render();
			//------------------------------   list of active classes
			$classification["list"]['list'][0][$c] = $v;
		}

		//------------------------------  global of classification card
		$classification['title'] = "classification";
		$classification["moreLink"] = "classification/status=detail/usersid=$users_id";
		
		$this->data->classification = $classification;

				//------------------------------  make olddb card
		$query_olddb = $this->sql("#olddb" , $users_id);
		if(!empty($query_olddb)){
			$olddb = array();
			$i = 1;
			foreach ($query_olddb as $key => $arrayValue) {
				if($key != "student"){
					$c = "&nbsp&nbspتعداد&nbsp&nbsp";
					$m = "&nbsp&nbspمورد&nbsp&nbsp";
				}else{
					$c = "";	
					$m = "";
				}
				$olddb["list"]['list'][0][$key] =
				 "<a>".$c .  $arrayValue . $m ."&nbsp&nbsp&nbsp&nbsp</a>"
				."<a href='olddb/" .$key . '/id='. $query_olddb['student'] . "'>نمایش کامل اطلاعات</a>";
				$i++;
					
			}
			
			//------------------------------  make global of olddb card
			$olddb['title'] = "olddb";
			// $olddb["moreLink"] = "olddb/status=detail/usersid=$users_id";
			$this->data->olddb = $olddb;
		}
	}
} 
?>