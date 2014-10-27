<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = 'register';
		$this->global->url ="users/status=edit/";
		// var_dump($this->urlStatus());
		$f = $this->form("@users", $this->urlStatus());
		$personForm = $this->form("@person");
		$f->add($personForm);


		// // set province list
		// $branch_list = $this->sql(".a");
		// $branch = $this->form("select")->name("branch_id")->classname("select-branch")->label("branch");
		// foreach ($branch_list as $key => $value) {
		// 	$branch->child()->name($value['name'])->label($value['name'])->value($value["id"]);
		// }
		// $branch->child(0)->selected("selected");
		// $f->add("branch", $branch);
		// $f->atFirst("branch");

		$this->listBranch($f);

		// set province list
		$province_list = $this->sql("#province_list");
		$province = $this->form("select")->name("province")->classname("select-province")->label("province");
		foreach ($province_list as $key => $value) {
			$province->child()->name($value['name'])->label($value['name'])->value($value["id"]);
		}
		$f->add("province", $province);
		$f->before("province", 'from');

		//set education list
		$education_list = $this->sql("#education_list");
		$education = $this->form("select")->name("education")->classname("select-education-group")->label("education_group");
		foreach ($education_list as $key => $value) {
			$education->child()->name($value['group'])->label($value['group'])->value($value['group']);
		}
		$education->child(0)->selected("selected");
		$f->add("education", $education);
		$f->after("education_id", 'city_id');
		$f->before("education", 'education_id');

		$phone = $this->form("#number")->name("phone")->label("phone");
		$phone->validate()->number(8);
		$f->add("phone", $phone);

		$mobile = $this->form("#number")->name("mobile")->label("mobile");
		$mobile->validate()->number(11);
		$f->add("mobile", $mobile);

		// $regulation = $this->form("checkbox")->name("agree")->label("I Agree");
		$f->nationality->child(35)->selected("selected");
		$f->nationality->addClass("select-nationality");

		// $f->add("regulation", $regulation);
		$f->remove("
			username,
			password,
			casecode,
			en_name,
			en_family,
			en_father,
			third_name,
			third_family,
			third_father,
			users_id
			");		
		$f->atEnd("email");
		$f->atEnd("regulation");

		// $regulation_tag = $this->tag("a")
		// ->text("نمایش آیین نامه")
		// ->attr("href", "regulation/")
		// ->addClass("a-undefault")
		// ->attr("target", "_blank");

		// $this->data->regulation = $regulation_tag->compile();

		if(isset($_SESSION['load_captcha'])){
			$captcha = $this->form("captcha");
			$f->add("captcha", $captcha);
			$f->atEnd("captcha");
		}

		$f->atEnd("submit");
		$f->marriage->child[0]->checked("checked");
		$hidden= $this->form("#hidden")->value("add_users");
		$f->add("hidden", $hidden);
		$f->atFirst("hidden");
		// var_dump($f->hidden);
		if(isset($_SESSION['gender'])){
			$x = ($_SESSION['gender'] == "male") ? 0 : 1;
			$f->gender->child($x)->checked("checked");
		}
		$this->sql(".edit", "person", $this->xuId(), $f);
	}
}

?>