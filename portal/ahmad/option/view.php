<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		$this->global->page_title = 'ahmad';

		$this->form('@ahmad', $this->urlStatus());
	}
}
?>