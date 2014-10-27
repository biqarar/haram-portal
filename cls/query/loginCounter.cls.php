<?php
class query_loginCounter_cls extends query_cls
{
	
	public function config() {

	}

	public function counter($type = "login", $cCount = 3, $cTime = 300) {

		$sql = $this->sql()->tableLogin_counter();
		$ip = $_SERVER['REMOTE_ADDR'];
		$n = $sql->whereIp($ip)->select();

		if($n->num() == 0) {

			$i = $this->sql()->tableLogin_counter()->setType($type)->setTime(time())->setCount(1)->setIp($ip)->insert();
			// debug_lib::fatal("$i");
			return true;
		}else{
			$ret = $n->assoc();
			$time = intval($ret['time']);
			$count = intval($ret['count']);
			if((time() - $time) > $cTime){
				$this->sql()->tableLogin_counter()
					->setTime(time())
					->setCount(1)
					->whereIp($ip)
					->update();
				return true;
			}elseif($count < $cCount) {
				$f = $this->sql()->tableLogin_counter()->setCount($count+1)->whereIp($ip);
				$f->update();
				return true;
			}else{
				$this->load_captcha();
				return false;
			}
		}
	}

	public function load_captcha() {
		$_SESSION['load_captcha'] = true;
	}

	public function register() {
		return $this->counter("register", 10, 600);	
	}

	public function clear() {
		$this->sql()->tableLogin_counter()->whereIp($_SERVER['REMOTE_ADDR'])->delete();
	}

	public function login() {
		return $this->counter("login", 3, 300);
	}
}
?>