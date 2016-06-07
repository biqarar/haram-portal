<?php
/**
 * @author reza mohiti rm.biqarar@gmail.com
 */
class view extends main_view {

	public function config(){
		//------------------------------  global
		$this->global->page_title = "price";

		//------------------------------ set users id
		$usersid = ($this->xuId("usersid") != 0) ? $this->xuId("usersid") : $this->sql("#find_usersid", $this->xuId("id"));	

		//------------------ check branch
		$this->sql(".branch.users",$usersid);

		$this->topLinks(array(
				array("title" => "آموزش", "url" => "users/learn/id=$usersid"),
				array("title" => "ثبت", "url" => "price/status=add/usersid=$usersid"),
				array("title" => "نمایش", "url" => "price/status=detail/usersid=$usersid")
			));

		//------------------------------  url
		$this->global->url .=  "/usersid=" . $usersid;
		$this->global->status =  gettext($this->urlStatus()); 
		// var_dump($this->global->url);exit();
		
		$f = $this->form('@price', $this->urlStatus());
		$f->type->child(1)->checked("checked");
		$f->remove("status");
		$f->title->child(0)->selected("selected");

		if($this->urlStatus() == "edit") {
			
			//------------------- check branch
			$this->sql(".branch.price", $this->xuId());

			$this->sql(".edit", "price", $this->xuId(), $f);
			

		}
		$price = $this->sql(".price.sum_price", $usersid);
		$this->global->sum_price = $price['sum_active'];
		//------------------------------  set name and family
		$this->global->name = $this->sql(".assoc.foreign", "person", $usersid, "name", "users_id")
							 . " " . 
							 $this->sql(".assoc.foreign", "person", $usersid, "family", "users_id");

		//------------------------------ load form
	}
}
?>