<?php
class model extends main_model {
	public function post_add_ahmad() {
		$this->sql()->tableAhmad()
			 ->setName(post::name())
			 ->setType(post::type())
			 ->setDescription(post::desc())
			 ->insert();
		$this->commit(function() {
			debug_lib::true('ok');
		});
	}	
}
?>