<?php
class model extends main_model {
	public function post_api() {
		debug_lib::msg($this->sql()->tableScore_type()->wherePlan_id($this->xuId())->select()->allAssoc());
	}
}
?>