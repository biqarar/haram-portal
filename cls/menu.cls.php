<?php
/**
*
*/
class menu_cls {

	static $menu = array();
	static $dropdown = array();
	static $list_menu = array();
	static function list_menu() {

		// var_dump($_SESSION);
		// if(isset($_SESSION['menu']) && !empty($_SESSION['menu'])){
		// 	return $_SESSION['menu'];
		// }

		self::menus();
		$make = false;
		foreach (self::$menu as $index => $value) {
			$make = false;
			if(is_string($value['tag']) && $value['tag'] == "public"){
				$make = true;
			}else{
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
			if($make) {
				self::$list_menu[$value['submenu']]["dropdown"][]
				=  array("url" => $value['url'] , "name" => $value["name"]);
			}
		}
		$index = array(
			"home" => 1,
			"teacher" => 2,
			"user"   => 3,
			"class"  => 4,
			"attendance" => 5,
			"letters" => 6,
			"share" => 7,
			"settings" => 8,
			"folder" => 9,
			"media" => 10
			);
		foreach (self::$list_menu as $key => $value) {
			self::$list_menu[$key]["name"] = _($key);
			self::$list_menu[$key]['index'] = $index[$key];
		}
		$_SESSION['menu'] = self::$list_menu;
		return self::$list_menu;
	}

	static function menus() {
		// city
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'city/status=add', 
			"name" =>  _("menu city add"), 
			"tag" => array(
				"city" => array("insert" => array("public"))
				)
			);
		
		// permission 
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'permission/status=add', 
			"name" =>  _("menu permission add"), 
			"tag" => array(
				"permission" => array("insert" => array("public"))
				)
			);

		// education 
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => 'education/status=add', 
			"name" =>  _("menu_education_add"), 
			"tag" => array(
				"education" => array("insert" => array("public"))
				)
			);
		
		// branch
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'branch/status=add', 
			"name" => _("menu branch add"), 
			"tag" => array(
				"branch" => array("insert" => array("public"))
				)
			);

		// group
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'group/status=add', 
			"name" =>  _("menu group add"), 
			"tag" => array(
				"group" => array("insert" => array("public"))
				)
			);

		// plan
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'plan/status=add', 
			"name" =>  _("menu plan add"), 
			"tag" => array(
				"plan" => array("insert" => array("public"))
				)
			);
		
		// course
		self::$menu[] = array(
			"submenu" => "share", 
			"url" => 'course/status=add', 
			"name" =>  _("menu course add"), 
			"tag" => array(
				"course" => array("insert" => array("public"))
				)
			);

		
		// abcence
		self::$menu[] = array(
			"submenu" => "home", 
			"url" => "absence/status=add", 
			"name" =>  _("menu absence add"), 
			"tag" => array(
				"absence" => array("insert" => array("public", "private"))
				)
			);


		//  person
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "users/status=add", 
			"name" =>  _("menu person add"), 
			"tag" => array(
				"users" => array("insert" => array("public", "private"))
				// "users" => array("insert" => array("public", "private"))
				)
			);

		// users list
		self::$menu[] = array(
			"submenu" => "user", 
			"url" => "users/status=list", 
			"name" =>  _("menu person list"), 
			"tag" => array(
				"person" => array("select" => array("public")),
				"users" => array("select" => array("public"))
				)
			);

		


		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "classes/status=list", 
			"name" =>  _("menu_classes_list"), 
			"tag" => array(
				"classes" => array("select" => array("public")),
				"classification" => array("insert" => array("public"))
				)
			);

		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "classes/status=add", 
			"name" =>  _("menu_classes_add"), 
			"tag" => array(
				"classes" => array("insert" => array("public"))
				)
			);

		self::$menu[] = array(
			"submenu" => "class", 
			"url" => "place/status=add", 
			"name" =>  _("menu_place_add"), 
			"tag" => array(
				"place" => array("insert" => array("public"))
				)
			);

		self::$menu[] = array(
			"submenu" => "letters", 
			"url" => "posts/status=add", 
			"name" =>  _("menu_posts_add"), 
			"tag" => array(
				"posts" => array("insert" => array("public"))
				)
			);
		
		// AT END //////////////////////////////////////////////////////////////////////////////////////////////////// AT END
		// $edit_user_url =  isset($_SESSION['users_id'])? $_SESSION['users_id'] : "0";
		// $edit_user_url = "users/edit/" . $edit_user_url;
		// self::$menu[] = array(
		// 	"submenu" => "settings", 
		// 	"url" => $edit_user_url,
		// 	"name" => _("menu user edit"), 
		// 	"tag" => "public"
		// 	);

		//logout - public menu
		self::$menu[] = array(
			"submenu" => "settings", 
			"url" => 'changepasswd', 
			"name" =>  _("change password"), 
			"tag" => "public"
			);

		self::$menu[] = array(
			"submenu" => "settings", 
			"url" => 'logout', 
			"name" =>  _("logout"), 
			"tag" => "public"
			);
		// self::$menu[] = array(
		// 	"submenu" => "home", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
		// 	"tag" => "public"
		// 	);
		// self::$menu[] = array(
		// 	"submenu" => "letters", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
		// 	"tag" => "public"
		// 	);
		// self::$menu[] = array(
		// 	"submenu" => "media", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
		// 	"tag" => "public"
		// 	);
		// self::$menu[] = array(
		// 	"submenu" => "settings", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
		// 	"tag" => "public"
		// 	);
		// self::$menu[] = array(
		// 	"submenu" => "share", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
		// 	"tag" => "public"
		// 	);
		// self::$menu[] = array(
		// 	"submenu" => "teacher", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
		// 	"tag" => "public"
		// 	);
		// self::$menu[] = array(
		// 	"submenu" => "user", 
		// 	"url" => 'public', 
		// 	"name" => _("logout"), 
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