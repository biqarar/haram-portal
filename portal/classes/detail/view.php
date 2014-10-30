 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "classes_detail";

		//------------------------------ list of classes
		$classes_detail = $this->sql(".list", "classes", function ($query) {
			$query->whereId($this->xuId());
		})->compile();

		//------------------------------ convert paln_id , teacher , place id , ... to name of this
		 $classes_detail = $this->detailClasses($classes_detail);
		

		$this->data->list = $classes_detail;
	}
}
?>