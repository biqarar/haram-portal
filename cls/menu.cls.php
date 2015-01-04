<?php
/**
*
*/
class menu_cls  {

	/**
	* list of menu (not compile)
	*/
	static $menu      = array();

	/**
	* list of menu dropdown (not compile)
	*/
	static $dropdown  = array();

	/**
	* list of menu (compiled)
	*/
	static $list_menu = array();

	/**
	* compile menu
	* @return array
	*/
	public function list_menu() {

		//------------------------------ make menu
		$this->menus();


		$make = false;

		foreach (self::$menu as $index => $value) {
			
			//------------------------------ key to load menu or no
			$make = false;
			
			//------------------------------ if tag of menu == public then do not neet to permission
			if(is_string($value['tag']) && $value['tag'] == "public"){
				$make = true;
			}elseif(is_string($value['tag']) && $value['tag'] != "public"){
				$make = false;
			}else{

				//------------------------------ check permission and make menu
				foreach ($value['tag'] as $table => $v) {
					foreach ($v as $oprator => $publicPrivate) {
						foreach ($publicPrivate as $i => $p) {
							if(isset($_SESSION['user_permission']['tables'][$table]) && isset($_SESSION['user_permission']['tables'][$table][$oprator])){
								if($_SESSION['user_permission']['tables'][$table][$oprator] == $p){
									$make = true;
									break;
								}	
							}
						}
						if($make) break;
					}
					if($make) break;
				}
			}

			//------------------------------ make menu and dropdown
			if($make || global_cls::supervisor()) {
				self::$list_menu[$value['submenu']]["dropdown"][]
				=  array("url" => $value['url'] , "name" => $value["name"]);
			}
		}

		//------------------------------ sort menu (not run)
		$index = array(
			"home"       => 1,
			"teacher"    => 2,
			"user"       => 3,
			"class"      => 4,
			"attendance" => 5,
			"letters"    => 6,
			"share"      => 7,
			"settings"   => 8,
			"folder"     => 9,
			"media"      => 10
			);

		//------------------------------ translate menu caption whit gettext()
		foreach (self::$list_menu as $key => $value) {
			self::$list_menu[$key]["name"] = _($key);
			// self::$list_menu[$key]['index'] = $index[$key];
		}

		//------------------------------ return
		return self::$list_menu;
	}

	/**
	* make array menu
	*/
	public function menus() {
		//------------------------------ hoem
		self::$menu[] = array(
			"submenu"     => "home",
			"url"         => 'profile',
			"name"        =>  _("home"),
			"tag"         => "public"
			);

		//------------------------------ news
		self::$menu[] = array(
			"submenu"     => "home",
			"url"         => 'profile',
			"name"        =>  _("اخبار مرکز"),
			"tag"         => "public"
			);

		//------------------------------ permission add
		self::$menu[] = array(
			"submenu"     => "home",
			"url"         => 'permission/status=add',
			"name"        =>  _("menu permission add"),
			"tag"         => array(
			"permission"  => array("insert" => array("public"))
				)
			);
		
		//------------------------------ permission add
		self::$menu[] = array(
			"submenu"     => "home",
			"url"         => 'pricechange/status=add',
			"name"        =>  _("مدیریت شهریه"),
			"tag"         => array(
			"price"  => array("insert" => array("public"))
				)
			);

		//------------------------------ city add
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'city/status=add', 
			"name" =>  _("menu city add"), 
			"tag" => array(
				"city" => array("insert" => array("public"))
				)
			);

		//------------------------------ province add
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'province/status=add', 
			"name" =>  _("ثبت استان ها"), 
			"tag" => array(
				"province" => array("insert" => array("public"))
				)
			);

		//------------------------------  education 
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'education/status=add', 
			"name" =>  _("menu_education_add"), 
			"tag" => array(
				"education" => array("insert" => array("public"))
				)
			);

		//------------------------------  country 
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'country/status=add', 
			"name" =>  _("menu_country_add"), 
			"tag" => array(
				"country" => array("insert" => array("public"))
				)
			);

		//------------------------------  branch
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'branch/status=add', 
			"name" => _("menu branch add"), 
			"tag" => array(
				"branch" => array("insert" => array("public"))
				)
			);

		//------------------------------  group
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'group/status=add', 
			"name" =>  _("menu group add"), 
			"tag" => array(
				"group" => array("insert" => array("public"))
				)
			);

		//------------------------------  plan
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'plan/status=add', 
			"name" =>  _("menu plan add"), 
			"tag" => array(
				"plan" => array("insert" => array("public"))
				)
			);
		
		//------------------------------  course
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'course/status=add', 
			"name" =>  _("menu course add"), 
			"tag" => array(
				"course" => array("insert" => array("public"))
				)
			);
		//------------------------------  if the teacher complete the form, menu not show else show the menu

		//------------------------------  teacher show detail 
		self::$menu[] = array(
			"submenu" => "teacher", 
			"url" => 'teacher/status=detail/id=' . $this->usersid(), 
			"name" =>  _("نمایش اطلاعات"), 
			"tag" => $this->teacher_form("show")
			);

		//------------------------------  teacher extera form
		self::$menu[] = array(
			"submenu" => "teacher", 
			"url" => 'teacher/extera/status=add/usersid=' . $this->usersid(), 
			"name" =>  _("تکمیل مشخصات"), 
			"tag" => $this->teacher_form("person_extera")
			);

		//------------------------------  teacher education 
		self::$menu[] = array(
			"submenu" => "teacher", 
			"url" => 'teacher/education/status=add/usersid=' . $this->usersid(), 
			"name" =>  _("اطلاعات تحصیلی"), 
			"tag" => $this->teacher_form("education_users")
			);

		//------------------------------  teacher bridge
		self::$menu[] = array(
			"submenu" => "teacher", 
			"url" => 'teacher/teachinghistory/status=add/usersid=' . $this->usersid(), 
			"name" =>  _("سوابق علمی و اجرایی"), 
			"tag" => $this->teacher_form("teachinghistory")
			);

		//------------------------------  teacher bridge
		self::$menu[] = array(
			"submenu" => "teacher", 
			"url" => 'teacher/bridge/status=add/usersid=' . $this->usersid(), 
			"name" =>  _("پل های ارتباطی"), 
			"tag" => $this->teacher_form("bridge")
			);
		
		//------------------------------  if the teacher complete the form, menu not show else show the menu
		
		//------------------------------   person
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "person/status=add", 
			"name" =>  _("menu person add"), 
			"tag" => array(
				"users" => array("insert" => array("public", "private"))
				)
			);
		//------------------------------  users list
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "users/status=list", 
			"name" =>  _("menu person list"), 
			"tag" => array(
				"person" => array("select" => array("public")),
				"users" => array("select" => array("public"))
				)
			);

		//------------------------------   price list
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "price/status=list", 
			"name" =>  "لیست شهریه ها", 
			"tag" => array(
				"price" => array("insert" => array("public", "private"))
				)
			);

		//------------------------------   bridge list
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "bridge/status=list", 
			"name" =>  "پل های ارتباطی", 
			"tag" => array(
				"bridge" => array("insert" => array("public", "private"))
				)
			);

		//------------------------------   bridge list
		self::$menu[] = array(
			"submenu" => "allteacher", 
			"url" => "teacher/status=list", 
			"name" =>  "لیست اساتید", 
			"tag" => array(
				"bridge" => array("insert" => array("public", "private"))
				)
			);

		//------------------------------ classes add
		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "classes/status=add", 
			"name" =>  _("menu_classes_add"), 
			"tag" => array(
				"classes" => array("insert" => array("public"))
				)
			);

		//------------------------------ classes list
		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "classes/status=list/", 
			"name" =>  _("list") . " " . _("classes") , 
			"tag" => array(
				"classes" => array("select" => array("public")),
				"classification" => array("insert" => array("public"))
				)
			);

		//------------------------------ plan add
		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "place/status=add", 
			"name" =>  _("menu_place_add"), 
			"tag" => array(
				"place" => array("insert" => array("public"))
				)
			);

		//------------------------------ classes list
		self::$menu[] = array(
			"submenu" => "attendance", 
			"url" => "classes/status=list/type=absence", 
			"name" =>  _("attendance"), 
			"tag" => array(
				"classes" => array("select" => array("public")),
				"classification" => array("insert" => array("public"))
				)
			);

		//------------------------------ posts add
		self::$menu[] = array(
			"submenu" => "letters", 
			"url" => "posts/status=add", 
			"name" =>  _("menu_posts_add"), 
			"tag" => array(
				"posts" => array("insert" => array("public"))
				)
			);


		//------------------------------ public menu

		//------------------------------ (public) change password menu 
		self::$menu[] = array(
			"submenu" => "settings", 
			"url" => 'settings', 
			"name" =>  _("تنظیمات شعب"), 
			"tag" => (isset($_SESSION['users_branch']) && count($_SESSION['users_branch']) > 1 ) ? "public" : "one branch"
			);
		//------------------------------ (public) change password menu 
		self::$menu[] = array(
			"submenu" => "settings", 
			"url" => 'changepasswd', 
			"name" =>  _("change password"), 
			"tag" => "public"
			);
		
		//------------------------------ (public) log out menu 
		self::$menu[] = array(
			"submenu" => "settings", 
			"url" => 'logout', 
			"name" =>  _("logout"), 
			"tag" => "public"
			);

		//------------------------------ (public) report bug menu 
		// self::$menu[] = array(
		// 	"submenu" => "letters", 
		// 	"url" => 'report/status=add', 
		// 	"name" => _("report"), 
		// 	"tag" => "public"
		// 	);

	}

	public function usersid() {
		if(isset($_SESSION['users_id'])) {
			return $_SESSION['users_id'];
		}else{
			return false;
		}
	}

	public function teacher_form() {
		if(isset($_SESSION['users_type']) && $_SESSION['users_type'] == "teacher") {
			return "public";
		}else{
			return "jost for teacher load this menu";
		}
	}

	public function x() {
		// if (!isset($this->usersid())) return false;
		return "public";
		$users_id = $this->usersid();
		// $form_users = $this->sql()->tableForm_users()->whereUsers_id($users_id)->select();
		// var_dump($form_users);
		// die();
	}

	public function public_menu() {
		return  array(
			array('href' => '#', 'title' => 'صفحه اصلی'),
			// array('href' => 'http://'.DOMAIN.'/portal/users/register', 'title' => 'ثبت نام'),
			array('href' => 'http://'.DOMAIN.'/portal/login', 'title' => 'ثبت نام'),
			array('href' => 'http://'.DOMAIN.'/portal/login', 'title' => 'ورود کاربران'),
			array('href' => 'posts/more', 'title' => 'اخبار بیشتر'),
		 	// array('href' => 'graduate/', 'title' => 'دانش آموختگان'),
			array('href' => 'strategy', 'title' => 'سیاست ها'),
		 	// array('href' => 'about', 'title' => 'درباره ما'),
			array('href' => 'contact', 'title' => 'تماس با ما'),
			);
	}
}
?>