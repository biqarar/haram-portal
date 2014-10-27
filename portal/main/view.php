<?php
class main_view{
	public $formIndex = array();
	public final function __construct($controller){
		$this->controller = $controller;
		$this->data = new aDATA();
		$this->data->global = new aData();
		$this->global = $this->data->global;

		// *********************************************************************** Site Global Variables
		$this->global->domain             = DOMAIN;
		$this->global->path               = PATH;
		$this->global->site_url           = 'http://'.DOMAIN.PATH;
		$this->global->site_static        = 'http://'.DOMAIN.PATH.'static/';

		$this->global->site_title         = "مرکز قرآن و حدیث";
		$this->global->site_desc          = "پورتال جامع مرکز قرآن و حدیث آستان مقدس حضرت فاطمه معصومه";
		$this->global->page_title_spliter = true;
		$this->global->page_title         = $this->global->site_title;
		$this->global->page_desc          = $this->global->site_desc;

		//$this->global->host = host;
		//$this->global->ahost = host.path;

		$this->global->menu = menu_cls::list_menu();


		// *********************************************************************** Other ...
		$this->form = (object) "form";
		unset($this->form->scalar);
		$this->data->form = $this->form;
		$this->data->layout = './main/display.html';
		// $this->data->homeLayout = './main/home.html';

		$this->data->macro['forms'] = 'macro/forms.html';
		$this->data->macro['list'] = 'macro/tagMaker.html';
		if(isset($_SESSION['error']) && isset($_SESSION['error'][config_lib::$URL]) && isset($_SERVER['HTTP_REFERER'])){
			$this->data->debug = $_SESSION['error'][config_lib::$URL];
			unset($_SESSION['error'][config_lib::$URL]);
		}

		if(method_exists($this, 'config')){
			$this->config();
			$this->checkRedirect();
		}
		$this->compile();

	}



	public final function form($type = false, $args = array()){
		$this->data->extendForm = true;
		$cForm = new forms_lib();
		$form = $cForm->make($type, $args);
		array_push($this->formIndex, $form);
		if(preg_match("/^@(.*)$/", $type, $name)){
			$this->form->{$name[1]} = $form;
		}
		return $form;
	}

	public final function compile(){
		if(isset($this->data->form)){
			$forms = $this->data->form;
			foreach ($forms as $key => $value) {
				if(method_exists($value, "compile")){
					$this->data->form->$key = $value->compile();
				}else{
					$this->data->form->$key = array();
					foreach ($value as $ckey => $cvalue) {
						if(!method_exists($cvalue, 'compile')){
							echo "$ckey not found compile";
							exit();
						}
						$this->data->form->{$key[$ckey]} = $cvalue->compile();
					}
				}
			}
		}
		$this->Localy();

		$Header = apache_request_headers();
		$tmpname		= config_lib::$class.'/'.config_lib::$method;
		$tmpname 		.= (config_lib::$child !='') ? '/'.config_lib::$child : '';
		$tmpname 		.='/display.html';
		if(ifAjax()){
			$this->data->layout = './main/xhr.html';
			echo '<div id="global">'.json_encode($this->global->compile())."</div>\n";
		}
		require_once core.'Twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();
		$loader		= new Twig_Loader_Filesystem(content);

		$twig		= new Twig_Environment($loader);
		$this->main_Extentions($twig);
		$template		= $twig->loadTemplate($tmpname);
		$template ->	display($this->data->compile());
	}

	public final function main_Extentions($twig){
		$twig->addFilter($this->twig_fcache());
		$twig->addFilter($this->twig_lang());
	}
	public function twig_fcache(){
		return new Twig_SimpleFilter('fcache', function ($string) {
			if(file_exists($string)){
				return $string.'?'.filemtime($string);
			}
		});
	}

	public function twig_lang(){
		return new Twig_SimpleFilter('lang', function ($string) {
			if(!empty($string)){
				$s = preg_split("/,/", $string);
				$a = array();
				foreach ($s as $key => $value) {
					array_push($a, gettext($value));
				}
				return join($a, '، ');
			}else{
				return $string;
			}
		});
	}

	public function __call($name, $args){
		if(preg_grep('/^'.$name.'$/', $this->controller->__autocallMethod)){
			return call_user_func_array(array($this->controller, $name), $args);
		}
	}

	public function __get($name){
		if(preg_grep('/^'.$name.'$/', $this->controller->__autogetProperty)){
			return $this->controller->$name;
		}else{
			return false;
		}
	}

	public function Localy(){
		/**
		 * forms
		 */
		$this->global->page_title = _($this->global->page_title);

	}

	public function listBranch($f, $type = "select") {
		$branch_list = $this->sql(".a");
		if($type == "select"){
			$branch = $this->form("select")->name("branch_id")->classname("select-branch")->label("branch");
			foreach ($branch_list as $key => $value) {
				$branch->child()->name($value['name'])->label($value['name'])->value($value["id"]);
			}
			$branch->child(0)->selected("selected");
			$f->add("branch", $branch);
			$f->atFirst("branch");
		}elseif ($type == "chekbox") {
			foreach ($branch_list as $key => $value) {
				$branch_id = $value['id'];
				$branch = $this->form("checkbox")->name("branch_$branch_id")->label($value['name'])->value($branch_id);
				$f->add("$branch_id", $branch);
				$f->atEnd("branch");
			}
		}

	}
}

class aDATA{
	function compile(){
		return ((array) $this);
	}
}
?>