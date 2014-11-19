<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */

class view extends main_view{

	public function config(){
		//------------------------------ global
		$this->global->page_title = "classes";

		//------------------------------ classes list
		$classes_detail = $this->sql(".list", "classes", function($query) {
			$query->limit(80);
		})

		//------------------------------ detail link
		->addCol("detail", "description")
		->select(-1, "detail")
		->html($this->detailLink("classes"))

		//------------------------------ edit link
		->addCol("edit", "edit")
		->select(-1, "edit")
		->html($this->editLink("classes"));

		//------------------------------ set type of list (absence | classification)
		$type = (isset(config_lib::$surl['type'])) ? config_lib::$surl['type'] : "classification";

		if($type == "classification"){

			//------------------------------ classification link
			$classes_detail = $classes_detail->addCol("classification","classification")
			->select(-1, "classification")
			->html($this->link("classification/class/classesid=%id%", "href", "ico icoclasses"));
			
		}elseif($type == 'absence'){

			//------------------------------ abcence link
			$classes_detail = $classes_detail->addCol("abcence","abcence")
			->select(-1, "abcence")
			->html($this->link("classification/absence/classesid=%id%", "href", "ico icoabsence"));
		}

		//------------------------------ print link
		$classes_detail = $classes_detail->addCol("print", "print")
		->select(-1, "print")
		->html($this->link("classification/printlist/classesid=%id%", "href" , "ico icoletters a-undefault"))
		//------------------------------ compile sql.list
		->compile();
		
		//------------------------------ convert paln_id , teacher , place id , ... to name of this
		$classes_detail = $this->detailClasses($classes_detail);
		

		$this->data->list = $classes_detail;
	}
}
?>