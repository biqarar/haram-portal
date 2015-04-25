<?php
class page_lib{
	public static function string($code){
		$error = array();
		$error[400] = 'BAD REQUEST';
		$error[401] = 'UNAUTHORIZED';
		$error[403] = 'FORBIDDEN';
		$error[404] = 'NOT FOUND';
		$error[405] = 'METHOD NOT ALLOWED';
		$error[408] = 'REQUEST TIME OUT';
		$error[410] = 'GONE';
		$error[411] = 'LENGTH REQUIRED';
		$error[412] = 'PRECONDITION FAILED';
		$error[413] = 'REQUEST ENTITY TOO LARGE';
		$error[414] = 'REQUEST URI TOO LARGE';
		$error[415] = 'UNSUPPORTED MEDIA TYPE';
		$error[500] = 'INTERNAL SERVER ERROR';
		$error[501] = 'NOT IMPLEMENTED';
		$error[502] = 'BAD GATEWAY';
		$error[503] = 'SERVICE UNAVAILABLE';
		$error[506] = 'VARIANT ALSO VARIES';
	}
	public static function page($str){
		$class = debug_backtrace(true);
		self::make("PAGE NOT FOUND($str)", $class, 404);
	}

	public static function core($str){
		$class = debug_backtrace(true);
		self::make("CORE NOT FOUND($str)", $class, 404);
	}

	public static function access($str){
		$class = debug_backtrace(true);
		self::make("ACCESS DENIED($str)", $class, 403);
	}

	public static function internal($str){
		$class = debug_backtrace(true);
		self::make("INTERNAL ERROR($str)", $class, 500);
	}
	public static function make($str, $obj, $status){
		header("HTTP/1.0 $status ".self::string($status));
		// echo "<h3>$status</h3><h5>$str</h5>";
		// exit();
		echo "<pre>$str";
		foreach ($obj as $key => $value) {
			if(array_key_exists('file', $obj[$key])){
				echo "\n\tat ".$obj[$key]['file'].':'.$obj[$key]['line'];
			}
		}
		echo "\n</pre>";
		exit();
	}
}

?>