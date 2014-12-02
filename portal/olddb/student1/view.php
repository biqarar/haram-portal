 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "student1";

		//------------------------------ list of classes
		$student1 = $this->sql(".list", "student1", function ($query, $id) {
			$query->whereUsers_id($id);
		}, $this->xuId())->compile();


		$this->data->list = $student1;
	}
}
?>