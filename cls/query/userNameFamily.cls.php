<?php
class query_userNameFamily_cls extends query_cls
{
	public function config($usersid = false) {
		$return =  $this->sql()->tablePerson()->whereUsers_id($usersid)->limit(1)->fieldName()->fieldFamily()->select()->assoc();
		return $return['name'] . " " . $return['family'];
	}


}
?>