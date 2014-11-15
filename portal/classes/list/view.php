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
		->html($this->editLink("classes"))

		//------------------------------ classification link
		->addCol("classification","classification")
		->select(-1, "classification")
		->html($this->link("classification/classesid=%id%", "href", "ico icoclasses"))

		//------------------------------ print link
		->addCol("print", "print")
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