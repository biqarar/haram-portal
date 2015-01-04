<?php 
/**
 * 
 */
class view extends main_view  {
	public function config() {
		//------------------------------  global
		$this->global->page_title = _("لیست غیبت هایی") . " " . _("student");

		//------------------------------  set users_id
		$users_id  = $this->xuId();
		//------------------------------ check users (if teacher , can not be display another users by id)
		$this->check_users_type($users_id);


		$this->global->users_datail = " لیست غیبت های ثبت شده برای فراگیر " . 
					$this->sql(".assoc.foreign" , "person", $users_id , "name" , "users_id")
					. '  ' . 
					$this->sql(".assoc.foreign" , "person", $users_id , "family" , "users_id");
				

		$allClassification = $this->sql(".list", "absence", function ($query, $id) {
			$query->joinClassification()->whereId("#absence.classification_id")->andUsers_id($id)->fieldUsers_id();
		}, $users_id);


		$this->data->list = $allClassification->compile();
	}
} 
?>