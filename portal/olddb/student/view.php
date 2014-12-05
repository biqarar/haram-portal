 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "student";

		//------------------------------ list of classes
		$student = $this->sql(".list", "student", function ($query, $id) {
			$query->whereName1($id);
		}, $this->xuId())->compile();


		$this->data->list = $student;
	}
}
?>