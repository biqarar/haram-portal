 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "certification";

		//------------------------------ list of classes
		$certification = $this->sql(".list", "oldcertification", function ($query, $id) {
			$query->whereParvande($id);
		}, $this->xuId())->compile();


		$this->data->list = $certification;
	}
}
?>