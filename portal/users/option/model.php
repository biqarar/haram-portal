<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function makeQuery() {

		//------------------------------ users sql object
		$sqlUsers = $this->sql()->tableUsers()
		->setEmail(post::email());

		//------------------------------ person sql object
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

		//------------------------------ check for empty text for name,family,father
		if(post::name() == '' || post::family() == '' || post::father() == ''){
			$key = false;
			debug_lib::fatal("empty name, family, father");
		}

		//------------------------------ check captcha if loaded
		if(isset($_SESSION['load_captcha']) && $_SESSION['load_captcha']) {
			if(post::captcha() != $_SESSION['CAPTCHA_GNA']){
				$key = false;
				debug_lib::fatal("captcha incorrect");
			}
		}

		//------------------------------ check duplicate record
		
		//------------------------------ if nationality is iran check nationalcode
		if(post::nationality() == 97) {
			$duplicate_person = $this
				->sql()
				->tablePerson()
				->whereNationalcode(post::nationalcode())
				->select()
				->num();
			
			if($duplicate_person >= 1) {
				$key = false;
				debug_lib::fatal("duplicate entry for national code");
			} 
		}


		//------------------------------ if no error in field
		if ($key){

			//------------------------------ check register counter
			//------------------------------ disable for portal
			//------------------------------ enable for real web site

			// if(!$this->sql(".loginCounter.register", "register") && (post::captcha() != $_SESSION['CAPTCHA_GNA'])){
			// 		debug_lib::fatal("[[insert users failed, 10 register in 600 Seconds!]]");
			// }else{
			// 		$this->sql(".loginCounter.clear");

			//------------------------------ get new username
			$username = $this->sql(".username.set");

			//------------------------------ sql object for insert
			list($users, $person) = $this->makeQuery();
			 
			//------------------------------ insert into users
			$users->setPassword(md5(post::nationalcode()))->setUsername($username);
			$sqlUsers = $users->insert();

			//------------------------------ get users_id to set into person table
			$users_id = $sqlUsers->LAST_INSERT_ID();

			//------------------------------ insert into person table
			$sqlPerson = $person->setUsers_id($users_id)->insert();
			
			//------------------------------ insert into bridge table, phone and mobile
			if(post::mobile() !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("mobile")->setValue(post::mobile())->insert();
			if(post::phone() !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("phone")->setValue(post::phone())->insert();
			
			//------------------------------ set users_branch if other sql is ok
			if(debug_lib::$status){
				$sqlBranch = $this->sql()->tableUsers_branch()
						->setUsers_id($users_id)
						->setBranch_id(post::branch_id())
						->insert();
			}

			//------------------------------ commit code
			$this->commit(function($username = false) {
				debug_lib::true("ثبت نام شما با موفقیت انجام شد ، نام کاربری شما  $username  و کلمه عبور شما کد ملی یا شماره گذر نامه شما می باشد.");
			}, $username);
		}

		$this->rollback(function() {
			debug_lib::fatal("[[insert users failed]]");
		});
	}

	public function post_edit_users() {
		// list($users, $person) = $this->makeQuery();
		// $sqlPerson = $person->whereId($this->uId())->update();
		// $sqlUsers = $users->whereId($sqlPerson->assoc('id'))->update();
		// $this->commit(function($id = false) {
		// 	debug_lib::true("[[update users successful]]");
		// }, $this->uId());
		// $this->rollback(function($id = false) {
		// 	debug_lib::fatal("[[update users failed]]");
		// }, $this->uId());
	}
}
?>