 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "person";

		//------------------------------ list of classes
		$person = $this->sql(".list", "person", function ($query, $id) {
			$query->whereUsers_id($id);
		}, $this->xuId())->compile();

		$this->data->list = $person;
	}
}
?>