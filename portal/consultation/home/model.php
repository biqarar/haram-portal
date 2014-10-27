<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class model extends main_model {
	public function sql_curl($curl = false) {
		return $this->sql()->tablePosts()->whereCurl($curl)->select()->assoc('id');
	}
}
?>