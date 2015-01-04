<?php
/**
* @author Reza Mohiti <rm.biqarar@gmail.com>
*/
class view extends main_view {

	public function config() {

		//------------------------------ globals
		$this->global->page_title = "absence";

		$users_id = $this->xuId("usersid");

		$this->global->usersid = $users_id;

		$this->global->users_datail = " ثبت غیبت برای فراگیر " . 
				$this->sql(".assoc.foreign" , "person", $users_id , "name" , "users_id")
				. '  ' . 
				$this->sql(".assoc.foreign" , "person", $users_id , "family" , "users_id");
			


		//------------------------------ make chane password form
		$active_classes = $this->sql("#active_classes", $users_id);
		// var_dump($active_classes); exit();
		$classes = array();
		$classes[] = $this->form("#hidden")->value("absence_add")->compile();
		foreach ($active_classes as $key => $value) {
			$x = $this->form("checkbox")
					->name("classes_" . $value["classes_id"])
					->label($this->sql("#classes_name", $value['classes_id']))
					->value($value['classification_id']);

			$classes[] = $x->compile();
		}

		//------------------------------ load form
		$f = $this->form("@absence", $this->urlStatus());
		$f->remove("classification_id");
		// unset($f->classification_id);
		// $classes[] = $this->form("#submitedit")->value("update")->compile();

		$this->data->classes = $classes;

		//------------------------------ edit form
		$this->sql(".edit", "absence", $this->xuId(), $f);

	}
}
?>