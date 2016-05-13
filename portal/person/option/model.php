<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{

	public function sql_load_file($person_id = false) {
		$users_id = $this->sql()->tablePerson()->whereId($person_id)->fieldUsers_id()->limit(1)->select()->assoc("users_id");
		return $this->load_file($users_id);
	}


	public function load_file($users_id = false) {

		$file_user = $this->sql()->tableFile_user()->whereUsers_id($users_id)->select();
		
		$directory = "portal/updfile/";

		$path = array();

		if($file_user->num() > 0 ) {
			foreach ($file_user->allAssoc() as $key => $value) {
				$file = $this->sql()->tableFiles()->whereId($value['file_id'])->limit(1)->select()->assoc();
				$path[] = $directory . $file['folder'] . '/' . $file['title'] . "." . $file['type'];
			}
		}
		return $path;

	}

	public function sql_find_from_name($id = false){
		$ret = '';
		if($id != ""){
			$sql = $this->sql()->tableCity()->whereId($id);
			$sql->joinProvince()->whereId("#city.province_id")->fieldName("pname");
			$r = $sql->limit(1)->select()->assoc();
				$ret = $r['pname'].' - '.$r['name'];
		}
		return $ret;
	}
	
	public function makeQuery() {

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
		->setMarriage(post::marriage())
		->setFrom(post::from())
		->setChild(post::child())
		->setEducation_id(post::education_id())
		->setEducation_howzah_id(post::education_howzah_id())

		->setPasport_date(post::pasport_date());

		// $from = post::from();
		// if(preg_match("/^\d$/", $from)){
		// 	$sqlPerson->setFrom(post::from());
		// }

		return $sqlPerson;
	}


	public function post_add_person() {

		$key = true;

		//------------------------------ check for empty text for name,family,father
		if(post::name() == '' || post::family() == '' || post::father() == ''){
			$key = false;
			debug_lib::fatal("نام، نام خانوادگی و نا ‍پدر وارد نشده است");
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
				debug_lib::fatal("کد ملی تکراری است");
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

			
			//------------------------------ insert into users
			//------------------------------ get users_id to set into person table
			$q_users_id  = $this->sql()->tableUsers()
						->setEmail(post::email())
						->setPassword(md5(post::nationalcode()))
						->setUsername($username)
						->insert();
			$users_id = $q_users_id->LAST_INSERT_ID();
			

			
			//------------------------------ insert into person table
			$person = $this->makeQuery()->setUsers_id($users_id)->insert();
			
			
			//------------------------------ insert into bridge table, phone and mobile
			if(post::mobile() !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("mobile")->setValue(post::mobile())->insert();
			if(post::mobile2() !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("mobile")->setValue(post::mobile2())->insert();
			if(post::phone()  !== "") $this->sql()->tableBridge()->setUsers_id($users_id)->setTitle("phone")->setValue(post::phone())->insert();
			
			//------------------------------ set users_branch if other sql is ok
			if(debug_lib::$status){
				$sqlBranch = $this->sql()->tableUsers_branch()
						->setUsers_id($users_id)
						->setBranch_id($this->post_branch())
						->insert();
				

			}

			//------------------------------ commit code
			$this->commit(function($username = false , $users_id = false) {
				debug_lib::true("ثبت نام با موفقیت انجام شد <br> 
								 نام کاربری شما  $username   <br>
								 و کلمه عبور شما کد ملی یا شماره گذر نامه شما می باشد.
								 ". 
								 "<br><br>" . 
								 $this->tag("a")
								 ->href("price/status=add/usersid=$users_id")
								 ->vtext("ثبت شهریه برای این فراگیر")
								 ->render()
								 );
			}, $username, $users_id);
		}

		$this->rollback(function() {
			debug_lib::fatal("[[insert users failed]]");
		});
	}

	public function post_edit_person() {

		//------------------ check branch
		$this->sql(".branch.person",$this->xuId());

		
		//----------------------------- update query
		$sql = $this->makeQuery()->whereId($this->xuId())->update();
		
	
		//----------------------------- commit code
		$this->commit(function() {
			debug_lib::true("[[update person successful]]");
		});
		
		//----------------------------- rool back code
		$this->rollback(function() {
			debug_lib::fatal("[[update person failed]]");
		});
	}
}
?>