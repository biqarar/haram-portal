 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "oldprice";

		//------------------------------ list of classes
		$oldprice = $this->sql(".list", "oldprice", function ($query, $id) {
			$query->whereUsers_id($id);
		}, $this->xuId())->compile();


		$this->data->list = $oldprice;
	}
}
?>