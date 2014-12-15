<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){

		//------------------------------ set global
		$this->global->page_title = "register";

		//------------------------------ load person form
		$f = $this->form("@person", $this->urlStatus());

		// ------------------------------add users form into person form (for set email)
		$usersForm = $this->form("@users");
		$f->add($usersForm);

		//------------------------------ remove some field (can not update or insert from users)
		$f->remove("username,status,type,password");
		$f->remove("casecode,casecode_old");

		//------------------------------ list of branch
		$this->listBranch($f);

		//------------------------------ set province list
		// $province_list = $this->sql(".assoc.province");
		// $province = $this->form("select")->name("province")->classname("select-province")->label("province");
		// foreach ($province_list as $key => $value) {
		// 	$province->child()->name($value['name'])->label($value['name'])->value($value["id"]);
		// }

		// $f->add("province", $province);
		// $f->before("province", 'from');
		$f->from->child = array();
		$f->from->type("text");
		//------------------------------set education list
		$f->education_id->addClass("notselect");

		//------------------------------ get phone number in form
		$phone = $this->form("#number")->name("phone")->label("phone");
		$phone->validate()->number(8);
		$f->add("phone", $phone);

		//------------------------------ get mobile number in form
		$mobile = $this->form("#number")->name("mobile")->label("mobile");
		$mobile->validate()->number(11);
		$f->add("mobile", $mobile);

		//------------------------------  default select Iran country
		$f->nationality->child(35)->selected("selected");
		$f->nationality->addClass("select-nationality")->addClass("notselect");

		//------------------------------  default check single
		$f->marriage->child(0)->checked("checked");

		//------------------------------ set defult gender whit sex users
		if(isset($_SESSION['users_gender'])){
			$x = ($_SESSION['users_gender'] == "male") ? 0 : 1;
			$f->gender->child($x)->checked("checked");
		}

		//------------------------------ check captcha if loaded
		if(isset($_SESSION['load_captcha'])){
			$captcha = $this->form("captcha");
			$f->add("captcha", $captcha);
			$f->atEnd("captcha");
		}

		//------------------------------ remove fields
		$f->remove("username,password,casecode,en_name,en_family,en_father,third_name,third_family,third_father,users_id");	

		//------------------------------ set email
		$f->atEnd("email");

		//------------------------------ set submit buttom
		$f->atEnd("submit");


		//------------------------------ edit peron but some field can not update
		if($this->urlStatus() == "edit"){
			$f->remove("email,mobile,phone");
			$this->sql(".edit", "person", $this->xuId(), $f);
		}
	}
}
?>