<?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {

	public function config() {
		$this->global->page_title = 'ahmad';

		$a = $this->form('@ahmad', $this->urlStatus());

		$this->sql('.edit', 'ahmad', $this->xuId(), $a);

		$this->data->xx = $this->sql('.list', 'ahmad', function($query){
			$query->limit(1);
		})->compile();
	}
}
?>