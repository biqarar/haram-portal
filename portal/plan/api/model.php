<?php

class model extends main_model {
	public function post_api() {
		$plan = $this->sql()->tablePlan()->whereId($this->xuId())->limit(1)->select()->assoc("price");
		debug_lib::msg("price", $plan);
	}
}

?>