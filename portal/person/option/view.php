<?php
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class view extends main_view{
	public function config(){

		//------------------------------ set global
		$this->global->page_title =_("person edit") .'  '. $this->xuId();

		//------------------------------ load person form
		$f = $this->form("@person", $this->urlStatus());

		//------------------------------ edit peron but some field can not update
		if($this->urlStatus() == "edit"){
			$f->remove("casecode");
			$f->remove("casecode_old");
			// $f->remove("type");
			// $f->remove("from");
			// $f->remove("nationality");
			// $f->remove("pasport_date");
			$this->sql(".edit", "person", $this->xuId(), $f);
			
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

		}
	}
}
?>