<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
		public function config() {
		$this->global->page_title = 'register';
		$this->global->url = $this->uStatus(true);
		$f = $this->form("@users", $this->uStatus());
		$personForm = $this->form("@person");
		$f->add($personForm);
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
		$f->add("education", $education);
		$f->after("education_id", 'city_id');
		$f->before("education", 'education_id');

		$mobile = $this->form("#number")->name("mobile")->label("mobile");
		$mobile->validate()->number(11);
		$f->add("mobile", $mobile);

		$regulation = $this->form("checkbox")->name("agree")->label("I Agree");
		$f->nationality->child(35)->selected("selected");
		$f->nationality->addClass("select-nationality");
		$f->add("regulation", $regulation);
		$f->remove("
			username,
			password,
			casecode,
			casecode_old,
			en_name,
			en_family,
			en_father,
			third_name,
			third_family,
			third_father,
			users_id,
			type
			");
		$f->atEnd("email");
		$f->atEnd("regulation");

		$regulation_tag = $this->tag("a")
		->text("show the regulation")
		->attr("href", "regulation/")
		->attr("target", "_blank");

		$this->data->regulation = $regulation_tag->compile();

		if(isset($_SESSION['load_captcha'])){
			$captcha = $this->form("captcha");
			$f->add("captcha", $captcha);
			$f->atEnd("captcha");
		}

		$f->atEnd("submit");
		$f->gender->child[0]->checked("checked");
		$f->marriage->child[0]->checked("checked");
		if(is_int($this->uId())){
			$this->sql(".edit", "person", $this->uId(), $f);
		}
	}
}
?>