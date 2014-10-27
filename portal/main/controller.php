<?php
class main_controller{
	public $onUrl = false;
	public $__autocallMethod = array("sql", "redirect", "checkRedirect", "addMethod", "addPeroperty");
	public $__autogetProperty = array( "redirect");
	public $access = false; // for after lunch
	// public $access = true; // for befor lunch
	public final function __construct(){
		if(preg_match("/favicon\.ico$/", $_SERVER['REQUEST_URI'])){
			die("fff");
		}
		$this->xuStatus();
		$permission = new checkPermission_cls;
		$permission->check();
		$this->querys = (object) "query";
		$this->addPeroperty('querys');
		$this->addMethod('tag');
		$this->addMethod('jTime');
		$this->addMethod('dateNow');
		$this->addMethod('xuStatus');
		$this->addMethod('urlStatus');
		$this->addMethod('uStatus');
		$this->addMethod('uId');
		$this->addMethod('xuId');
		if(method_exists($this, 'config')){
			$this->config();
		}
		list($access, $msg) = $this->checkPermissions();
		if(!$access) {
			if(ifAjax()){
				page_lib::access($msg);				
			}else{
				$_SESSION['redirect'] = config_lib::$URL;
				header("location:".host.'/login');
			}
		}
		// exit();
	}

	public final function hendel(){
		$sMod = config_lib::$mod;
		$this->$sMod = new $sMod($this);
	}

	public final function addMethod($name){
		array_push($this->__autocallMethod, $name);
	}

	public final function addPeroperty($name){
		array_push($this->__autogetProperty, $name);
	}

	public final function sql($name){
		preg_match("/^(\.|@|#)?([a-z0-9_]*|([a-z0-9_]+)\.([a-z0-9_]+))$/Ui", $name, $type);
		$args = func_get_args();
		$args = array_splice($args, 1);

		if($type[1] == "@"){
			return call_user_func_array(array($this->model(), 'sql_'.$type[2]), $args);
		}elseif($type[1] == "." || count($type) == 5){
			$sClass = (count($type) == 5) ? $type[3] : $type[2];
			$qClass = "query_".$sClass.'_cls';
			$qMethod = (count($type) == 5) ? $type[4] : 'config';
			return call_user_func_array(array(new $qClass, $qMethod), $args);
		}elseif($type[1] == "#"){
			$qMethod = "sql_{$type[2]}";
			return call_user_func_array(array($this->model(), $qMethod), $args);
		}

	}

	public final function model(){
		if(!isset($this->model)){
			$this->model = new model($this, true);
		}
		return $this->model;
	}
	public final function view(){
		if(!isset($this->view)){
			$this->view = new view($this, true);
		}
		return $this->view;
	}

	public final function redirect($redirect = false, $exit = true, $php = false){
		$redirectClass = new redirector_cls($redirect, $exit, $php);
		$this->redirect = $redirectClass;
		return $redirectClass;
	}

	public final function checkRedirect(){
		if(isset($this->redirect) && is_object($this->redirect)){
			$this->redirect->redirect();
		}
	}

	public final function listen($cond, $callback = false){
		if(is_array($cond)){
			$listen = new listen_cls($cond);
			$cond = $listen->cond;
		}
		if($cond){
			$this->onUrl = true;
			if(gettype($callback) == 'object'){
				$args = func_get_args();
				$this->CallBackFunc = $callback;
				call_user_func_array($this->CallBackFunc, array_splice($args, 2));
			}else if(is_array($callback)){
				save($callback);
			}
		}
	}

	public function tag($tag = false) {
		return new tagMaker_lib($tag);
	}

	public function jTime() {
		return new jTime_lib;
	}

	public function dateNow() {
		return $this->jTime()->date("Ymd", false, false);
	}

	public function xuStatus($c = false) {
		$URL = config_lib::$URL;
		$aurl = config_lib::$aurl;
		$surl = config_lib::$surl;
		$table = preg_split("/\//", $URL);
		$table = $table[0];
		$return = array();
		$return['table'] = $table;
		if($c){
			$return[$c] = isset($surl[$c]) ? $surl[$c] : false;
		}else{
			$return['surl'] = $surl;
		}
		
		$insertORupdate = (isset($surl['status']) && $surl['status'] == 'add') ? "insert" : "update";
		if(isset($surl['status']) && ($surl['status'] == 'add' || $surl['status'] == 'edit')){
			$a = $surl["status"];
			$this->listen(
				array(
					"max" => 3,
					'url' => array("status" => "$a")
					),
				function($table, $insertORupdate){
					save(array("$table", "option"));
					$this->permission = array("$table" => array("$insertORupdate" => array("public")));
				}, $table , $insertORupdate	);
			
		}elseif(isset($surl['status']) && $surl['status'] == 'list' ){
			$a = $surl["status"];
			$this->listen(
				array(
					"max" => 3,
					'url' => array("status" => "$a")
					),
				function($table){
					save(array("$table", "list"));
					$this->permission = array("$table" => array("select" => array("public")));
				}, $table
				);
		}elseif(isset($surl['status']) && $surl['status'] == 'detail' ){
			$a = $surl["status"];
			$this->listen(
				array(
					"max" => 3,
					'url' => array("status" => "$a")
					),
				function($table){
					save(array("$table", "detail"));
					$this->permission = array("$table" => array("select" => array("public")));
				}, $table
				);
		}
	}

	public function urlStatus() {
		return (config_lib::$surl['status']) ? config_lib::$surl['status']: "add";
	}

	public function xuId() {
		return (isset(config_lib::$surl['id'])) ? config_lib::$surl['id']: 0;
	}
	public function uStatus($index = 1, $url = false, $url2 = false){
		if(is_bool($index)) {
			$url = true;
			$url2 = $url ? true : false;
			$index = 1;
		}
		$ret = isset(config_lib::$aurl[$index]) ? config_lib::$aurl[$index] : '' ;
		if($url){
			$ret .= isset(config_lib::$aurl[$index+1]) ? '/'.config_lib::$aurl[$index+1] : '';
		}
		if($url2){
			$ret .= isset(config_lib::$aurl[$index+2]) ? '/'.config_lib::$aurl[$index+2] : '';
		}
		return $ret;
	}


	public function uId($index = 2){
		return (isset(config_lib::$aurl[$index])) ? intval(config_lib::$aurl[$index]) : false ;
	}

	public function permissionStatus() {
		if($this->uStatus() == 'add') return "insert";
		if($this->uStatus() == 'edit') return "update";

	}

	public function checkPermissions() {
		$msg = "";
		$access = false;
		if($this->access) {
			// For Login page
			$access = true;
		}elseif (!isset($this->access)) {
			// Developer bug !!!
			$access = false;
			$msg = "access not found";
		}elseif (!isset($this->permission)) {
			// Developer bug !!!
			$access = false;
			$msg = "permission not set";

		}else{
			// check permission
			$session_permission = isset($_SESSION['user_permission']['tables']) ? $_SESSION['user_permission']['tables'] : false;
			$page_permission = $this->permission;
			$closeF = false;
			foreach ($page_permission as $table => $oprator) {
				if(isset($session_permission[$table])){
					foreach ($oprator as $op => $public_private) {
						foreach ($public_private as $key => $value) {
							if(isset($session_permission[$table][$op]) && $session_permission[$table][$op]==$value){
								$access = true;
							}
							if($closeF) break;
						}
						if($closeF) break;
					}
				}
				if($closeF) break;
			}
			$msg = "permission denide";
		}
		return array($access, $msg);
	}
}
?>