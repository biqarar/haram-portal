<?php
class query_username_cls extends query_cls
{
	public function set() {
		$year = "394";
		$isset_key = $this->sql()->tableBranch_users_key()->wherePkey($year)->limit(1)->select();
		if($isset_key->num() == 0) {
			$this->sql()->tableBranch_users_key()->setPkey($year)->setKey("1")->insert();
			
		}else{
			$new_key = intval($isset_key->assoc("key"));
			$new_key++;
			$this->sql()->tableBranch_users_key()->setKey($new_key)->wherePkey($year)->update();
		}
		$ret = $this->sql()->tableBranch_users_key()->wherePkey($year)->limit(1)->select()->assoc();
		$newUsername = $ret['pkey']. $ret['key'];
		$check = $this->sql()->tableUsers()->whereUsername($newUsername)->limit(1)->select();

		if($check->num() == 0){
			return $newUsername;	
		}else{
			$loop = true;
			while ($loop) {
				$isset_key = $this->sql()->tableBranch_users_key()->wherePkey($year)->limit(1)->select();
				if($isset_key->num() == 0) {
					$this->sql()->tableBranch_users_key()->setPkey($year)->setKey("1")->insert();
					$loop = false;
					$ret = $this->sql()->tableBranch_users_key()->wherePkey($year)->limit(1)->select()->assoc();
					$newUsername = $ret['pkey']. $ret['key'];
					
				}else{
					$new_key = intval($isset_key->assoc("key"));
					$new_key++;
					$this->sql()->tableBranch_users_key()->setKey($new_key)->wherePkey($year)->update();
					$ret = $this->sql()->tableBranch_users_key()->wherePkey($year)->limit(1)->select()->assoc();
					$newUsername = $ret['pkey']. $ret['key'];
					$check = $this->sql()->tableUsers()->whereUsername($newUsername)->limit(1)->select();
					if($check->num() == 0){
						$loop = false;
					}
				}
			}
			return $newUsername;
		}
		
		// return $ret['pkey']. $ret['key'];
	}

	public function updateKey(){

	}

	public function get($users_id =false) {
		$us = $this->sql()->tablePerson()->whereUsers_id($users_id)->limit(1)->select()->assoc();
		return $us['name'] . ' ' . $us['family'];
	}

}
?>