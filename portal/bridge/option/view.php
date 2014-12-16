<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */


class view extends main_view {

	public function config(){

		//------------------------------ global
		$this->global->page_title = "bridge";

		//------------------------------ check users (if teacher, can not be display by changing id)
		$this->check_users_type($this->xuId("usersid"));

		//------------------------------ load bridge form
	    $f = $this->form('@bridge', $this->urlStatus());

	    //------------------------------ set users_id
	    $users_id =  $this->xuId("usersid");

	    //------------------------------ put users_id in hidden input to get in model.php
	    $f->users_id->value($users_id);

	    //------------------------------ list of bridge fo this user
    	$list = $this->sql(".list", "bridge" , function($query, $users_id){
    		$query->whereUsers_id($users_id);
    	}, $users_id);

    	//------------------------------ edit link
    	$list = $this->editCol("bridge", $list, $this->link("bridge/status=edit/usersid=$users_id/id=%id%" , "href", "icoedit"));

    	$this->data->list = $list->compile();

    	//------------------------------ load edit form
	    if($this->urlStatus() == "edit"){
			$this->sql(".edit", "bridge", $this->xuId(), $f);	    
	    }

	}
}
?>