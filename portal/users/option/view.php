<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {

		// ------------------------------ globals
		$this->global->page_title = 'register';

		$this->global->url = "status=" . $this->urlStatus();

		// ------------------------------ load form
		$f = $this->form("@users", $this->urlStatus());
		// ------------------------------add person form into users form
		$personForm = $this->form("@person");
		$f->add($personForm);

		// ------------------------------ load list of branch whit select box
		$this->listBranch($f);


		//------------------------------ set province list
		$province_list = $this->sql(".assoc.province");
		$province = $this->form("select")->name("province")->classname("select-province")->label("province");
		foreach ($province_list as $key => $value) {
			$province->child()->name($value['name'])->label($value['name'])->value($value["id"]);
		}
		$f->add("province", $province);
		$f->before("province", 'from');

		//------------------------------set education list
		$education_list = $this->sql(".assoc.education");
		$education = $this->form("select")->name("education")->classname("select-education-group")->label("education_group");
		foreach ($education_list as $key => $value) {
			$education->child()->name($value['group'])->label($value['group'])->value($value['group']);
		}
		$education->child(0)->selected("selected");
		$f->add("education", $education);
		$f->after("education_id", 'city_id');
		$f->before("education", 'education_id');

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
		$f->nationality->addClass("select-nationality");

		//------------------------------  default check single
		$f->marriage->child(0)->checked("checked");

		//------------------------------ remove fields
		$f->remove("username,password,casecode,en_name,en_family,en_father,third_name,third_family,third_father,users_id");		
		
		//------------------------------ set email at end form
		$f->atEnd("email");

		//------------------------------ check captcha if loaded
		if(isset($_SESSION['load_captcha'])){
			$captcha = $this->form("captcha");
			$f->add("captcha", $captcha);
			$f->atEnd("captcha");
		}

		//------------------------------ set submit buttom
		$f->atEnd("submit");

		//------------------------------ set post_add_users input hidden
		$hidden= $this->form("#hidden")->value("add_users");		
		$f->add("hidden", $hidden);
		$f->atFirst("hidden");

		//------------------------------ set defult gender whit sex users
		if(isset($_SESSION['gender'])){
			$x = ($_SESSION['gender'] == "male") ? 0 : 1;
			$f->gender->child($x)->checked("checked");
		}

		//------------------------------ edit person form whit id
		$this->sql(".edit", "person", $this->xuId(), $f);
	}
}

?>