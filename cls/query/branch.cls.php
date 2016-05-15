<?php 
class query_branch_cls extends query_cls {

	public function __construct() {
		if(!isset($_SESSION['user']['id'])){
			header("location:" . host . "/login");
			exit();
		}
	}

	public function get_list() {
		$listBranch = $this->sql()->tableBranch();
			
		foreach ($this->check() as $key => $value) {
			if($key == 0) {
				$listBranch->whereId($value);
			}else{
				$listBranch->orId($value);
			}
		}
		return  $listBranch->select()->allAssoc();
	}


	public function get_users_branch() {
		$listBranch = $this->sql()->tableUsers_branch()->whereUsers_id($_SESSION['user']['id'])
		->andStatus("enable");
		$listBranch->groupOpen();
		foreach ($this->check() as $key => $value) {
			if($key == 0) {
				$listBranch->andBranch_id($value);
			}else{
				$listBranch->orBranch_id($value);
			}

		}
		$listBranch->groupClose();
		$listBranch->joinBranch()->whereId("#users_branch.branch_id")->fieldName();
		return  $listBranch->select()->allAssoc();
	}

	
	
	public function check($arg = false) {

		//--------------- supervisor can see all branch list and data
		if(global_cls::supervisor()) {
		
			return ($arg) ? $arg : $this->allBranch("id");
		
		}

		//--------------- $arg = branch_id
		if($arg){	
			foreach ($this->_list() as $key => $value) {
				
				if($value == $arg) {
					//--------------- the branch founded in branch list
					//---------- return branch id 
					return $value;
				}
			}
			//--------------- this branch not set on users branch
			// return false;
			$this->error();

		}else{
			//--------------- return all branch users active
			return $this->_list();
		}
	}

	public function _list(){
		return isset($_SESSION['user']['branch']['selected']) ?  
					 $_SESSION['user']['branch']['selected'] :
					 $_SESSION['user']['branch']['active'];
	}

	public function post_branch() {
		if(post::branch_id()){
			if($this->check(post::branch_id())){
				return post::branch_id();
			}
		}elseif(count($this->check()) == 1) {
			return $this->_list()[0];
		}else{
			$this->error("شناسه شعبه یافت نشد");
		}
	}


	/**
	* classification JOIN classes JOIN plan and select brach id
	*/
	public function classification($classification_id = false) {
		//--------------- 
		$query = $this->sql()->tableClassification()->whereId($classification_id)->limit(1)->select()->assoc("classes_id");

		return $this->classes($query);
	}


	/**
	* classes  JOIN plan and select brach id
	*/
	public function classes($classes_id = false) {
		//--------------- 
		$query = $this->sql()->tableClasses()->whereId($classes_id)->limit(1)->select()->assoc("plan_id");
		
		return $this->plan($query);
	}

	/**
	* absence  JOIN classification JOIN classes JOIN plan and select brach id
	*/
	public function absence($absence_id = false) {
		//--------------- 
		$query = $this->sql()->tableAbsence()->whereId($absence_id)->limit(1)->fieldClassification_id();

		return $this->classification($query->select()->assoc("classification_id"));
	}

	/**
	* users  JOIN userbranch and select brach id
	*/
	public function users($users_id = false, $branch_id = false) {
		//--------------- 
		$query = $this->sql()->tableUsers_branch()->whereUsers_id($users_id)->select()->allAssoc();
		$in_branch = false;
		if($branch_id) {
			foreach ($query as $key => $value) {
				if($this->check($value['branch_id'])  && $value['branch_id'] == $branch_id){
					return  $branch_id;
				}
			}
			//the branch of reques not in this users
			$this->error("شعبه کاربر با شعبه طرح/کلاس مغایر است");
		}else{
			foreach ($query as $key => $value) {
				if($this->check($value['branch_id'])){
					$in_branch =   $this->check($value['branch_id']) ;
				}
			}
		}
		if($in_branch) {
			return $in_branch;
		}else{
			$this->error();
		}
	}

	public function person($person_id = false) {
		$query = $this->sql()->tablePerson()->whereId($person_id)->limit(1)->select()->assoc("users_id");
		return $this->users($query);
	}

	public function certification($certification_id = false) {
		$query = $this->sql()->tableCertification()->whereId($certification_id)->limit(1)->select()->assoc("classification_id");
		return $this->classification($query);
	}

	public function plan ($plan_id = false) {
		//--------------- 
		$query = $this->sql()->tablePlan()->whereId($plan_id)->limit(1)->select()->assoc("branch_id");

		return $this->check($query);
	}

	public function score($score_id = false) {
		$query =$this->sql()->tableScore()->whereId($score_id)->limit(1)->select()->assoc("classification_id");

		return $this->classification($query);
	}

	public function score_type($score_type_id = false) {
		$query = $this->sql()->tableScore_type()->whereId($score_type_id)->limit(1)->select()->assoc("plan_id");

		return $this->plan($query);
	}

	public function score_calculation($score_calculation_id = false) {
		$query = $this->sql()->tableScore_calculation()->whereId($score_calculation_id)->limit(1)->select()->assoc("plan_id");

		return $this->plan($query);
	}

	public function group ($group_id = false) {
		//--------------- 
		$query = $this->sql()->tableGroup()->whereId($group_id)->limit(1)->select()->assoc("branch_id");

		return $this->check($query);
	}

	public function place ($place_id = false) {
		//--------------- 
		$query = $this->sql()->tablePlace()->whereId($place_id)->limit(1)->select()->assoc("branch_id");

		return $this->check($query);
	}

	public function price_change($price_change_id = false) {
		$query = $this->sql()->tablePrice_change()->whereId($price_change_id)->limit(1)->select()->assoc("branch_id");

		return $this->check($query);	
	}

	public function price($price_id = false) {
		$query = $this->sql()->tablePrice()->whereId($price_id)->limit(1)->select()->assoc("users_id");

		return $this->users($query);
	}


	public function course($course_id = false) {

		//--------------- 
		$query = $this->sql()->tableCourse()->whereId($course_id)->limit(1)->select()->assoc("branch_id");

		return $this->check($query);
	}

	public function courseclasses($courseclasses_id = false ){
		$query = $this->sql()->tableCourseclasses()->whereId($courseclasses_id)->limit(1)->select()->assoc("course_id");
		return $this->course($query);
	}
	
	

	public function allBranch($field = false) {
		return $this->sql()->tableBranch()->select()->allAssoc($field);
	}

	public function olddb($table = false, $id = false) {
		$table = "table" .ucfirst($table);
		$query = $this->sql()->$table()->whereId($id)->limit(1)->select()->assoc("branch");
		return $this->check($query);
	}

	public function error($msg = "اشکال در تطابق شناسه شعبه"){
		// var_dump("error");exit();
		debug_lib::fatal($msg);
	}
}
?>
