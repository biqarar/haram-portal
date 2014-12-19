<?php 
/**
* 
*/
class menu_cls {

	static $menu = array();

	static function list_menu() {
		self::make_menu();
		return self::$menu;		
	}

	static function make_array_menu($main_id, $main_name, $dropdown) {
		self::$menu[]     = array(
			"main_id"   => $main_id,
			"main_name" => $main_name,
			"dropdown"  => $dropdown
			);
	}

	static function make_dropdown($name, $url) {
		return array('url' => $url, 'name' => $name);
	}
	static function make_menu() {
		$dropdown = array(
			self::make_dropdown('استان ها', 'province/add'),
			self::make_dropdown('شهر ها', 'city/add'),
			self::make_dropdown('کشور ها', 'country/add'),
			self::make_dropdown('تحصیلات', 'education/add'),
			self::make_dropdown('مدرس ها', 'place/add'),
			self::make_dropdown('سمت ها', 'position/add'),
			self::make_dropdown('نشانک ها', 'tags/add'),
			self::make_dropdown('سوابق مسابقه', 'racehistory/add'),
			self::make_dropdown('سوابق آموزشی', 'teachinghistory/add'));
		self::make_array_menu('home', "خانه", $dropdown);
		
		$dropdown = array(
			self::make_dropdown('شعب', 'branch/add'),
			self::make_dropdown('گروه علمی', 'group/add'),
			self::make_dropdown('دوره ها', 'course/add'),
			self::make_dropdown('طرح ها', 'plan/add'),
			self::make_dropdown('دسترسی', 'permission/add'));
		self::make_array_menu('share', 'گروه ها', $dropdown);
		
		$dropdown = array(
			self::make_dropdown('ثبت پرسنل', 'users/add'),
			self::make_dropdown('گروه های شغلی', 'group/expert/add'));
		self::make_array_menu('teacher', 'پرسنل', $dropdown);
		
		$dropdown = array(
			self::make_dropdown('ثبت فراگیر', 'users/add'),
			self::make_dropdown('فراگیران', 'users'),
			self::make_dropdown('پل ارتباطی', 'bridge/add'),
			self::make_dropdown('دانش آموختگان', 'graduate/add'));
		self::make_array_menu('user', 'فراگیران', $dropdown);		

		$dropdown = array(
			self::make_dropdown('ثبت کلاس', 'classes/add'),
			self::make_dropdown('اطلاح اطلاعات کلاس', 'classes/edit'),
			self::make_dropdown('نمایش کلاس ها', 'classes'),
			self::make_dropdown('غیبت ها', 'absence/add'),
			self::make_dropdown('لیست انتظار کلاس', '/'),
			self::make_dropdown('کلاس بندی', 'classification/add'));
		self::make_array_menu('class', 'کلاس ها', $dropdown);

		$dropdown = array(
			self::make_dropdown('ثبت درخواست', '/'),
			self::make_dropdown('نمایش درخواست ها', '/'),
			self::make_dropdown('پیگیری', '/'));
		self::make_array_menu('letters', 'درخواست ها', $dropdown);

		$dropdown = array(
			self::make_dropdown('اضافه کردن فایل', 'files/add'),
			self::make_dropdown('نمایش فایل ها', 'files/'));
		self::make_array_menu('folder', 'فایل ها', $dropdown);

		$dropdown = array(
			self::make_dropdown('اضافه کردن خبر', 'posts/add'),
			self::make_dropdown('نمایش اخبار', '/'));
		self::make_array_menu('media', 'پست ها', $dropdown);
		
		$dropdown = array(
			self::make_dropdown('تغییر رمز', '/'),
			self::make_dropdown('نمایش اطلاعات', '/'),
			self::make_dropdown('تاریخچه فعالیت', '/'),
			self::make_dropdown('خروج', '/'));
		self::make_array_menu('settings', 'امکانات', $dropdown);

	}
}
?>