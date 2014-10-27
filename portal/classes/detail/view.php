 <?php
/**
 * @author Ahmad Karimi <ahmadkarimi1991@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->page_title = "classes_detail";
		$this->data->list = $this->sql(".list", "classes", function ($query) {
			$query->whereId($this->xuId());
		})->compile();
	}
}
?>