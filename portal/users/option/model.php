<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function makeQuery() {

		$sqlUsers = $this->sql()->tableUsers()
		->setEmail(post::email());

		$sqlPerson = $this->sql()->tablePerson()
		->setName(post::name())
		->setFamily(post::family())
		->setFather(post::father())
		->setBirthday(post::birthday())
		->setGender(post::gender())
		->setNationality(post::nationality())
		->setNationalcode(post::nationalcode())
		->setCode(post::code())
		->setFrom(post::from())
		->setMarriage(post::marriage())
		->setChild(post::child())
		->setType(post::type())
		->setEducation_id(post::education_id())
		->setPasport_date(post::pasport_date());

		return array($sqlUsers, $sqlPerson);

	}

	public function post_add_users() {
		$key = true;

		if(post::name() == '' || post::family() == '' || post::father() == ''){
			$key = false;
			debug_lib::fatal("[[empty name, family, father]]");
		}

		// I Agree the regulation
		// if(!post::agree()) {
		// 	$key = false;
		// 	debug_lib::fatal("[[please agree the regulation]]");
		// } 
		
		if(isset($_SESSION['load_captcha']) && $_SESSION['load_captcha']) {
			if(post::captcha() != $_SESSION['CAPTCHA_GNA']){
				$key = false;
				debug_lib::fatal("captcha incorrect");
			}
		}
		if ($key){
			// if(!$this->sql(".loginCounter.register", "register") && (post::captcha() != $_SESSION['CAPTCHA_GNA'])){
			// 	debug_lib::fatal("[[insert users failed, 10 register in 600 Seconds!]]");
			// }else{
			// $this->sql(".loginCounter.clear");

			$username = $this->sql(".username.set");
			list($users, $person) = $this->makeQuery();
			 
			$users->setPassword(md5(post::nationalcode()))->setUsername($username);
			$sqlUsers = $users->insert();
			$users_id = $sqlUsers->LAST_INSERT_ID();
			$sqlPerson = $person->setUsers_id($users_id)->insert();
			
			if(post::mobile() !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("mobile")->setValue(post::mobile())->insert();
			if(post::phone() !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("phone")->setValue(post::phone())->insert();
			
			if(debug_lib::$status){
				$sqlBranch = $this->sql()->tableUsers_branch()
				->setUsers_id($users_id)
				->setBranch_id(post::branch_id())
				->insert();
			}

			$this->commit(function($username = false) {
				debug_lib::true("ثبت نام شما با موفقیت انجام شد ، نام کاربری شما  $username  و کلمه عبور شما کد ملی یا شماره گذر نامه شما می باشد.");
			}, $username);
			// }
		}

		$this->rollback(function() {
			debug_lib::fatal("[[insert users failed]]");
		});
	}

	public function post_edit_users() {
		list($users, $person) = $this->makeQuery();
		$sqlPerson = $person->whereId($this->uId())->update();
		$sqlUsers = $users->whereId($sqlPerson->assoc('id'))->update();
		$this->commit(function($id = false) {
			debug_lib::true("[[update users successful]]");
		}, $this->uId());
		$this->rollback(function($id = false) {
			debug_lib::fatal("[[update users failed]]");
		}, $this->uId());
	}
}
?>