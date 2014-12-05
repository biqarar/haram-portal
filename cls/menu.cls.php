<?php
/**
*
*/
class menu_cls {

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
	static function list_menu() {

		//------------------------------ make menu
		self::menus();


		$make = false;
		
		foreach (self::$menu as $index => $value) {
			
			//------------------------------ key to load menu or no
			$make = false;
			
			//------------------------------ if tag of menu == public then do not neet to permission
			if(is_string($value['tag']) && $value['tag'] == "public"){
				$make = true;
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
			if($make) {
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
			self::$list_menu[$key]['index'] = $index[$key];
		}

		//------------------------------ return
		return self::$list_menu;
	}

	/**
	* make array menu
	*/
	static function menus() {
		//------------------------------ permission add
		self::$menu[] = array(
			"submenu"     => "home",
			"url"         => 'permission/status=add',
			"name"        =>  _("menu permission add"),
			"tag"         => array(
			"permission"  => array("insert" => array("public"))
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

		//------------------------------  education 
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'education/status=add', 
			"name" =>  _("menu_education_add"), 
			"tag" => array(
				"education" => array("insert" => array("public"))
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

		//------------------------------   person
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "users/status=add", 
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
			"url" => "classes/status=list/type=classification", 
			"name" =>  _("classification"), 
			"tag" => array(
				"classes" => array("select" => array("public")),
				"classification" => array("insert" => array("public"))
				)
			);
		
		//------------------------------  absence
		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "classes/status=list/type=absence", 
			"name" =>  _("menu absence add"), 
			"tag" => array(
				"absence" => array("insert" => array("public", "private"))
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
		/**

		*/
		//------------------------------ (public) log out menu 
		self::$menu[] = array(
			"submenu" => "media", 
			"url" => 'formmaker/group/status=add', 
			"name" =>  _("form group"), 
			"tag" => array(
				"form_group" => array("insert" => array("public")),
				)
			);
		//------------------------------ (public) log out menu 
		self::$menu[] = array(
			"submenu" => "media", 
			"url" => 'formmaker/questions/status=add', 
			"name" =>  _("form questions"), 
			"tag" => array(
				"form_questions" => array("insert" => array("public")),
				)
			);
		//------------------------------ (public) log out menu 
		self::$menu[] = array(
			"submenu" => "media", 
			"url" => 'formmaker/groupitem/status=add', 
			"name" =>  _("form group item"), 
			"tag" => array(
				"form_group_item" => array("insert" => array("public")),
				)
			);
		//------------------------------ (public) log out menu 
		self::$menu[] = array(
			"submenu" => "media", 
			"url" => 'formmaker/testrun/formid=1', 
			"name" =>  _("test run form"), 
			"tag" => array(
				"form_answer" => array("select" => array("public")),
				)
			);
		/**

		*/

		//------------------------------ (public) report bug menu 
		// self::$menu[] = array(
		// 	"submenu" => "letters", 
		// 	"url" => 'report/status=add', 
		// 	"name" => _("report"), 
		// 	"tag" => "public"
		// 	);

	}

	static function public_menu() {
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