 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "price";

		//------------------------------ list of classes
		$price = $this->sql(".list", "price", function ($query) {
			$query->whereUsers_id($this->xuId("usersid"));
		})->compile();

		$this->data->list = $price;
	}
}
?>