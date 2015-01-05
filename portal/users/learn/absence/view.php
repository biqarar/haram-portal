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
				

		$this->data->dataTable = $this->dtable("users/learn/listabsence/status=xapi/usersid=$users_id/"
					, array('id', "classes_id", "plan", "teacher", 'date', 'type', "edit"));
	}
} 
?>